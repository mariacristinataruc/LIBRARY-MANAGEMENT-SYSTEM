<?php
$logged_out = isset($_GET['logged_out']) && $_GET['logged_out'] == 'true';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookED</title>
    <link rel="stylesheet" href="css/login-style.css">
</head>
<body>
    <div class="whole-main">
        <div class="navbar">
            <div class="logo">
                <img src="assets/booked.png" alt="Logo">
            </div>                
            <a href="#home">Home</a>
            <a href="#contact">Contact</a>
            <a href="#about">About</a>   
        </div>
        <?php if ($logged_out): ?>
        <script>
            alert("You have been logged out successfully!");
        </script>
    <?php endif; ?>
        <div class="login">
            <span>Login</span>
            <form action="" method="POST">
                <input type="text" name="uname" placeholder="username" id="uname" required>
                <input type="password" name="pword" placeholder="password" id="pword" required>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
        <div class="tagline">   
            <span>Improves The Lives of </span><br>
            <span>People and Communities</span>
        </div>
        <div class="box2"></div>             
    </div>
</body>
</html>
<?php
  // Start the session
  session_start();

  // Report all PHP errors
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "library-ms";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input data
    $uname = $conn->real_escape_string($_POST['uname']);
    $pword = $conn->real_escape_string($_POST['pword']);

    // Use prepared statements to prevent SQL injection
    $sql = $conn->prepare("SELECT as_id, as_uname, as_pword, as_fname, as_lname, as_email, as_pnum, ur_id 
                           FROM `admin-staff` 
                           WHERE as_uname = ? AND as_pword = ?");
    $sql->bind_param("ss", $uname, $pword);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
      // Output data of each row
      while($row = $result->fetch_assoc()) {
        // Store user information in session variables
        $_SESSION['as_uname'] = $row['as_uname'];
        $_SESSION['as_fname'] = $row['as_fname'];
        $_SESSION['as_lname'] = $row['as_lname'];

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
      }
    } else {
      echo "<script>alert('Mismatched Credentials, Try Again!');</script>";
    }

    // Close the prepared statement
    $sql->close();
  }

  // Close the connection
  $conn->close();
?>
