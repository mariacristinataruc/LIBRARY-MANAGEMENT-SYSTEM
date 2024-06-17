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



// Retrieve admin staff IDs
$adminStaffResult = $conn->query("SELECT as_ID, as_fname, as_lname FROM `admin-staff`");
$adminStaffOptions = '';
if ($adminStaffResult->num_rows > 0) {
    while ($row = $adminStaffResult->fetch_assoc()) {
        $adminStaffOptions .= "<option value='" . $row['as_ID'] . "'>" . $row['as_fname'] . " " . $row['as_lname'] . " (" . $row['as_ID'] . ")</option>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Instructor</title>
    <link rel="shortcut icon" href="assets/professor.png">
    
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
    background: linear-gradient(#898121,#E7B10A);
    
    
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
    background-color: #F7F1E5;
    
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
                    <span>Add New Instructor</span>
                </div>
            </div>

            <div class="input-new">

                <div class="back-btn">
                    <a href="instructors.php"><button><img src="assets/back.png"></button></a>

                    <div class="menu-logo">
                        <img src="assets/professor.png">
                    </div>  
                </div>

                <form action="instructors.php" method="POST">
    <div class="field">
        <div class="input">
          <span>FIRST NAME :</span>
            <input type="text" placeholder="first Name" name="fname" required> 
        </div>
        <div class="input">
        <span>LAST NAME :</span>
            <input type="text" placeholder="last Name" name="lname" required> 
        </div>

        <div class="input">
        <span>DEPARTMENT :</span>
            <select name="dept" required>
                <option value="" disabled selected>Select your department</option>
                <option value="CTE">COLLEGE OF TEACHER EDUCATION</option>
                <option value="CAS">COLLEGE OF ARTS AND SCIENCES</option>
                <option value="CBE">COLLEGE OF BUSINESS EDUCATION</option>
                <option value="SCJE">SCHOOL OF CRIMINAL JUSTICE EDUCATION</option>
            </select>
        </div>

        <div class="input">
        <span>EMAIL :</span>
            <input type="email" placeholder="Email" name="email" required> 
        </div>
        <div class="input">
          <span>PHONE NUMBER :</span>
            <input type="number" placeholder="phone number" name="pnum" required> 
        </div>

        <div class="input">
            <!-- Dropdown for Admin ID -->
             <span>SELECT ADMIN / STAFF ID :</SPAN>
            <select name="stname" required>
                <option value="">select admin / staff ID</option>
                <?php
                // Database connection
                $servername = "localhost";  
                $username = "root";
                $password = "";
                $dbname = "library-ms";
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch admin IDs from admin-staff table
                $sql = "SELECT as_ID, CONCAT(as_fname, ' ', as_lname) AS full_name FROM `admin-staff`";
                $result = $conn->query($sql);

                // Populate dropdown options
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['as_ID'] . "'>" . $row['full_name'] . " (" . $row['as_ID'] . ")</option>";
                    }
                }

                $conn->close();
                ?>
            </select>
        </div>
    </div>
                                
    <div class="add-new">
        <input type="submit" value="Submit"><img src="assets/add.png">
    </div>
</form>
</body>
</html>
