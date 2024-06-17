<?php
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

// Initialize variables to hold form data
$studID = $bookID = $bordate = $retdate = $expdate = $state = $stfID = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $studID = $_POST['studID'] ?? '';
    $bookID = $_POST['bookID'] ?? '';
    $bordate = $_POST['bordate'] ?? '';
    $retdate = $_POST['retdate'] ?? '';
    $expdate = $_POST['expdate'] ?? '';
    $state = $_POST['state'] ?? '';
    $stfID = $_POST['stfID'] ?? '';
    
    // Validate form data (add more validation as needed)
    if (!empty($studID) && !empty($bookID) && !empty($bordate) && !empty($retdate) && !empty($expdate) && !empty($state) && !empty($stfID)) {
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("INSERT INTO `book-student` (stud_ID, b_ID, bs_borDate, bs_retDate, bs_expDate, bs_state, as_ID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $studID, $bookID, $bordate, $retdate, $expdate, $state, $stfID);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "New record added successfully";
            // Optionally redirect after successful insertion
            // header("Location: bor-studs.php");
            // exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error: Form data is incomplete";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Borrow-Student</title>
    <link rel="shortcut icon" href="assets/borrow.png">
    
</head>
<style>
    /*import Google Font*/
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');


.whole-main {
    position:absolute;
    width: 1244px;
    height: 692px;
    margin: 0 auto;
    background: #E7B10A;
    overflow: hidden;
    cursor: pointer;
    font-family: "Poppins", Arial, Helvetica, sans-serif;
  }

  .menu-bar{
    position: absolute;
    overflow: hidden;
    width: 250px;
    height: 678px;
    margin: 7px 7px;
    border-radius: 10px;
    background-color:#B7BC4F;
  }

  .admin{
    position:absolute;
    margin: 20px 0 0 75px;
    width: 110px;
    height: 120px;
    text-align: center;
    }

  .admin img{
    margin: 15px 0 10px 10px ;
  }

  .admin span{
    text-align: center;
  }

  .dash-menu{
    position: absolute;
    margin: 180px 0 0 0;
    height: 440px;
    width:250px;
    justify-content: space-evenly;
    display: flex;
  }

  .dash-menu img{
    margin: 5px 0 0 10px;
  }

  .dash-menu span{
    position: absolute;
    margin:15px 0 0 15px;
    font-size: 12px;
  }

  .dashboard{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    background-color: #F7F1E5;
  }

  .staff-admin{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    margin: 55px 0 0 0;
    background-color: #F7F1E5;
  }

  .instructors{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    margin: 110px 0 0 0;
    background-color: #F7F1E5;
    
  }

  .students{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    margin: 165px 0 0 0;
    background-color: #F7F1E5;
    
  }

  .books{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    margin: 220px 0 0 0;
    background-color: #F7F1E5;
  }

  .bor-instructs{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    margin: 275px 0 0 0;
    background-color: #F7F1E5;
    
  }

  .bor-studs{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    margin: 330px 0 0 0;
    background: linear-gradient(#898121,#E7B10A);
    
    
  }

  .b-inventory{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    margin: 385px 0 0 0;
    background-color: #F7F1E5;
  }

  .main-dash{
    position: absolute;
    width:970px;
    height:678px;
    margin: 7px 7px;
    border-radius: 10px;
    left: 259px;
    background-color: #F7F1E5;

  }

  
  .nav-dash{
    position: absolute;
    width:970px;
    height:50px;
    margin:8px 0; 
  }

  .logo img{
    position: absolute;
    height: 60px;
    width:60px;
    margin: 0 20px;
    overflow: hidden;
  }

  .logo span{
    position: absolute;
    margin:9px 0 0 90px;
    font-size: 20px;
    font-family: Poppins;
  }

  .input-new{
    position: absolute;
    height: 562px;
    width:920px;
    margin: 100px 25px 25px 25px;
    border-radius: 10px;
    background-color: #bbc06c;
  }

  .back-btn{
    position: relative;
    height:45px;
    width:45px;
    border-radius: 20px;
    margin:20px 0 0 20px;
  }

  .back-btn button{
    position:absolute;
    height:50px;
    width:50px;
    background-color: transparent;
    border-radius: 20px;
    border: none;
    
  }

  .back-btn button img{
    position:relative;
    height: 35px;
    width: 35px;
  }

  .menu-logo img{
    position: absolute;
    height: 50px;
    width: 50px;
    margin: 0 0 0 800px;
  }
  
  .add-new{
    position: absolute;
    height:35px;
    width:120px;
    left:120px;
    border-radius: 10px;
    background-color: #898121;
    margin:100px 0 0 650px;
  }

  .add-new input {
    position:relative;
    height:35px;
    width:120px;
    background-color: #E7B10A;
    border-radius: 10px;
    padding-left: 30px;
    border:none;
  }

  .add-new img{
    position:absolute;
    top:6px;
    left:10px;
    height: 25px;
    width: 25px;
  }
  
  .field{
    position: relative;
    height:300px;
    width:700px;
    display: grid;
    margin: auto;
    top:50px;
    grid-template-columns: repeat(2, 1fr);
   
  }

  .input input{
    display: flex;
    flex-direction: column;
    height: 45px;
    width: 300px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.386);
    border-radius: 10px;
    border: none;
    padding-left: 15px;
    text-align: left;
  }

  select{
    display: flex;
    flex-direction: column;
    height: 45px;
    width: 300px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.386);
    border-radius: 10px;
    border: none;
    padding-left: 15px;
    padding-top:12px;
    font-size:15px;
    text-align: left;
  }

  
    </style>

<body>
    
    <div class="whole-main">
        <div class="menu-bar">
            <div class="admin">
                <img src="assets/admin.png" style="height: 50px;width: 50px;">
            </div>

            <div class="dash-menu">
                <div class="dashboard">
                    <img src="assets/dash.png" style="height:35px;width:35px;">
                    <span>Dashboard</span>
                </div>
                
                <div class="staff-admin">
                    <img src="assets/group.png" style="height:35px;width:35px;">
                    <span>Staff and Admin</span>
                </div>

                <div class="instructors">
                    <img src="assets/professor.png" style="height:35px;width:35px;">
                    <span>Instructors</span>
                </div>

                <div class="students">
                    <img src="assets/stud.png" style="height: 35px;width:35px;">
                    <span>Students</span>
                </div>

                <div class="books">
                    <img src="assets/bookss.png" style="height: 35px;width:35px;">
                    <span>Books</span>
                </div>

                <div class="bor-instructs">
                    <img src="assets/borrow.png" style="height: 35px;width:35px;">
                    <span>Borrowed by Instructors</span>
                </div>

                <div class="bor-studs">
                    <img src="assets/borrow.png" style="height: 35px;width:35px;">
                    <span>Borrowed by Students</span>
                </div>

                <div class="b-inventory">
                    <img src="assets/ready-stock.png" style="height: 35px;width:35px;">
                    <span>Books Inventory</span>
                </div>
            </div>

        </div>

        <div class="main-dash">
            <div class="nav-dash"> 
                <div class="logo">
                    <img src="assets/booked.png">
                    <span>New Borrow by Student</span>
                </div>
            </div>

            <div class="input-new">

                <div class="back-btn">
                    <a href="bor-studs.php"><button><img src="assets/back.png"></button></a>

                    <div class="menu-logo">
                        <img src="assets/borrow.png">
                    </div>  
                </div>
 <form action="bor-studs.php" method="POST">
                    <div class="field">
                        <!-- Form fields for bor-studs.php -->
                        <!-- Status -->
                        <div class="input"> 
                      <span style="font-weight:700;color: #1A4D2E;text-shadow: 0 2px 4px #F5EFE6;">STATUS :</span>
                        <select name="state" required>
                            <option value="" disabled selected>select status</option>
                            <option value="borrow">borrow</option>
                            <option value="return">return</option>
                        </select>
                    </div>

                        <!-- Book ID -->
                        <div class="input">
                            <span style="font-weight:700;color: #1A4D2E;text-shadow: 0 2px 3px #F5EFE6;">BOOK ID :</span>  
                            <select name="bookID" required>
                                <option value="">Select Book ID</option>
                                <?php
                                // Fetch book IDs from books-info table
                                $sql = "SELECT b_ID, b_title FROM `book-info`";
                                $result = $conn->query($sql);

                                // Populate dropdown options
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['b_ID'] . "'>" . $row['b_title'] . " (" . $row['b_ID'] . ")</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Borrowed Date -->
                        <div class="input">
                            <span style="font-weight:700;color: #1A4D2E;text-shadow: 0 2px 4px #F5EFE6;">BORROWED DATE :</span>
                            <input type="date" placeholder="borrowed date" name="bordate" style="font-size: x-large;" required> 
                        </div>

                        <!-- Student ID -->
                        <div class="input">
                            <span style="font-weight:700;color: #1A4D2E;text-shadow: 0 2px 3px #F5EFE6;">STUDENT ID :</span>  
                            <select name="studID" required>
                                <option value="">Select Student ID</option>
                                <?php
                                // Fetch student IDs from students table
                                $sql = "SELECT stud_ID, CONCAT(studFname, ' ', studLname) AS full_name FROM `students`";
                                $result = $conn->query($sql);

                                // Populate dropdown options
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['stud_ID'] . "'>" . $row['full_name'] . " (" . $row['stud_ID'] . ")</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Return Date -->
                        <div class="input">
                            <span style="font-weight:700;color: #1A4D2E;text-shadow: 0 2px 4px #F5EFE6;">RETURN DATE :</span>  
                            <input type="date" placeholder="return date" name="retdate" style="font-size: x-large;" required> 
                        </div>

                        <!-- Admin/Staff ID -->
                        <div class="input">
                            <span style="font-weight:700;color: #1A4D2E;text-shadow: 0 2px 3px #F5EFE6;">ADMIN / STAFF ID :</span>  
                            <select name="stfID" required>
                                <option value="">Select Admin-Staff ID</option>
                                <?php
                                // Fetch admin staff IDs from admin-staff table
                                $sql = "SELECT as_ID, CONCAT(as_fname, ' ', as_lname) AS full_name FROM `admin-staff`";
                                $result = $conn->query($sql);

                                // Populate dropdown options
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['as_ID'] . "'>" . $row['full_name'] . " (" . $row['as_ID'] . ")</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Expected Date -->
                        <div class="input">
                            <span style="font-weight:700;color: #1A4D2E;text-shadow: 0 2px 3px #F5EFE6;">EXPECTED DATE :</span>  
                            <input type="date" placeholder="expected date" name="expdate" style="font-size: x-large;" required> 
                        </div>
                    </div>

                    <div class="add-new">
                        <input type="submit" value="Add"><img src="assets/add.png">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>