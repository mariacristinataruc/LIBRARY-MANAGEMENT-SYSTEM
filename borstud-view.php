<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library-ms";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the existing data for the given ID
    $sql = "SELECT * FROM `book-student` WHERE bs_ID ='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Record not found";
        exit();
    }

    // Fetch book title
    $bookID = $row['b_ID'];
    $bookSql = "SELECT b_title FROM `book-info` WHERE b_ID='$bookID'";
    $bookResult = $conn->query($bookSql);
    $bookTitle = ($bookResult && $bookResult->num_rows > 0) ? $bookResult->fetch_assoc()['b_title'] : 'Unknown Book';

    // Fetch student name
    $studID = $row['stud_ID'];
    $studSql = "SELECT studFname, studLname FROM `students` WHERE stud_ID='$studID'";
    $studResult = $conn->query($studSql);
    if ($studResult && $studResult->num_rows > 0) {
        $studRow = $studResult->fetch_assoc();
        $studName = $studRow['studFname'] . ' ' . $studRow['studLname'];
    } else {
        $studName = 'Unknown Student';
    }

    // Fetch staff name
    $stfID = $row['as_ID'];
    $stfSql = "SELECT as_fname, as_lname FROM `admin-staff` WHERE as_ID='$stfID'";
    $stfResult = $conn->query($stfSql);
    if ($stfResult && $stfResult->num_rows > 0) {
        $staffRow = $stfResult->fetch_assoc();
        $staffName = $staffRow['as_fname'] . ' ' . $staffRow['as_lname'];
    } else {
        $staffName = 'Unknown Staff';
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Borrow-Student</title>
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
    color:light gray;
    font-weight:700;
    background:white;
    cursor:pointer;
  }

  .input span{
    font-weight:700;color: #1A4D2E;text-shadow: 0 2px 3px #F5EFE6;
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
    color:gray;


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
                    <span>View Borrow by Student</span>
                </div>
            </div>

            <div class="input-new">

                <div class="back-btn">
                    <a href="bor-studs.php"><button><img src="assets/back.png"></button></a>

                    <div class="menu-logo">
                        <img src="assets/borrow.png">
                    </div>  
                </div>
                
        <div class="field">
                    <div class="input">
                        <span>BORROW-STUDENT ID :</span>
                        <input type="text" name="id" value="<?php echo $row['bs_ID']; ?>" disabled>
                    </div>

                    <div class="input">
                        <span>BOOK :</span>
                        <input type="text" name="bookID" value="<?php echo htmlspecialchars($bookTitle); ?>" disabled>
                    </div>
                    
                    <div class="input">
                        <span>STUDENT :</span>
                        <input type="text" name="instID" value="<?php echo htmlspecialchars($studName); ?>" disabled>
                    </div>
                    
                    <div class="input">
                        <span>RETURN DATE :</span>
                        <input type="text" name="retdate" value="<?php echo htmlspecialchars($row['bs_retDate']); ?>" disabled>
                    </div>
                    
                    <div class="input">
                        <span>STATUS :</span>
                        <input type="text" name="state" value="<?php echo htmlspecialchars($row['bs_state']); ?>" disabled>
                    </div>
                    
                    <div class="input">
                        <span>BORROWED DATE :</span>
                        <input type="text" name="bordate" value="<?php echo htmlspecialchars($row['bs_borDate']); ?>" disabled>
                    </div>
                    
                    <div class="input">
                        <span>STAFF :</span>
                        <input type="text" name="stfID" value="<?php echo htmlspecialchars($staffName); ?>" disabled>
                    </div>
                    
                    <div class="input">
                        <span>EXPIRY DATE :</span>
                        <input type="text" name="expdate" value="<?php echo htmlspecialchars($row['bs_expDate']); ?>" disabled>
                    </div>
        </div>
    
</body>
</html>
