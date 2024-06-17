<?php
session_start();

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

// SQL query to count the number of students
$sql = "SELECT COUNT(*) AS total_students FROM students";
$result = $conn->query($sql);
$total_students = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_students = $row['total_students'];
}

// SQL query to count the number of instructors
$sql = "SELECT COUNT(*) AS total_instructors FROM instructors";
$result = $conn->query($sql);
$total_instructors = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_instructors = $row['total_instructors'];
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="assets/dash.png">
</head>
<style>
    /*import Google Font*/
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

.whole-main {
    position:relative;
    width: 1244px;
    height: 720px;
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
    height: 700px;
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
    margin: 8px 0 0 0 ;
  }

  .admin span{
    text-align: center;
    font-weight: 900;
    color:rgb(56, 55, 55);
    
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
    color: black;
  }

  .dashboard{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    background: linear-gradient(#898121,#E7B10A);
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
    height:700px;
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

  .total{
    display: flex;
    justify-content: space-evenly;
    height:130px; 
    width:970px;
    margin: 70px 0 20px;
    align-items: center;
  }

  .tot{
    height:120px;
    width:180px;
    background: linear-gradient(#E7B10A,#B7BC4F);
    border-radius: 10px;
  }

  .tot img{
    position: absolute;
    padding: 15px 5px;
  }

  .tot span{
    position: absolute;
    margin:90px 0 0 30px;
    font-size: 15px;
  }

  .tot-num{
    position: absolute;
    font-size: 40px;
    text-align:left;
    margin: 0 0 0 95px;
    color: #F7F1E5;
    top:90px;
  }


#calendar-container {
    width: 800px;
    margin: 0 auto;
    text-align: left;
    background-color: white;
    padding:30px;
    padding-top:0;
    border-radius: 10px;
}

#calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#calendar {
    width: 100%;
    border-collapse: collapse;
    height: 200px;
    top:20px;
}

#calendar th, #calendar td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

#calendar th {
  background: linear-gradient(#B7BC4F,#E7B10A);
}

#calendar td {
    cursor: pointer;
}

#calendar td:hover {
    background-color: #f1f1f1;
}

.current-day {
  background: linear-gradient(#B7BC4F,#E7B10A);
    color: white;
}


  .staff-admin:hover{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    margin: 55px 0 0 0;
    background: linear-gradient(#898121,#E7B10A);
  }

  .instructors:hover{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    margin: 110px 0 0 0;
    background: linear-gradient(#898121,#E7B10A);
  }

  .students:hover{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    background: linear-gradient(#898121,#E7B10A);
  }

  .books:hover{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    background: linear-gradient(#898121,#E7B10A);
  }

  .bor-instructs:hover{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    background: linear-gradient(#898121,#E7B10A);
  }

  .bor-studs:hover{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    background: linear-gradient(#898121,#E7B10A);
  }

  .b-inventory:hover{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    background: linear-gradient(#898121,#E7B10A);
  }
    </style>
<body>
    <div class="whole-main">
        <div class="menu-bar">
            <div class="admin">
                <img src="assets/admin.png" style="height: 50px;width: 50px;"><br>
                <span><?php echo $_SESSION['as_fname'] ?></span>
            </div>

             <div class="dash-menu">

                <div class="dashboard"><a href="dashboard.php">
                    <img src="assets/dash.png" style="height:35px;width:35px;">
                    <span>Dashboard</span></a>
                </div>
                
                <div class="staff-admin"><a href="staff-admin.php">
                    <img src="assets/group.png" style="height:35px;width:35px;">
                    <span>Staff and Admin</span></a>
                </div>

                <div class="instructors"><a href="instructors.php">
                    <img src="assets/professor.png" style="height:35px;width:35px;">
                    <span>Instructors</span></a>
                </div>

                <div class="students"><a href="students.php">
                    <img src="assets/stud.png" style="height: 35px;width:35px;">
                    <span>Students</span></a>
                </div>

                <div class="books"><a href="books.php">
                    <img src="assets/bookss.png" style="height: 35px;width:35px;">
                    <span>Books</span></a>
                </div>

                <div class="bor-instructs"><a href="bor-instructs.php">
                    <img src="assets/borrow.png" style="height: 35px;width:35px;">
                    <span>Borrowed by Instructors</span></a>
                </div>

                <div class="bor-studs"><a href="bor-studs.php">
                    <img src="assets/borrow.png" style="height: 35px;width:35px;">
                    <span>Borrowed by Students</span></a>
                </div>

                <div class="b-inventory"><a href="book-invent.php">
                    <img src="assets/ready-stock.png" style="height: 35px;width:35px;">
                    <span>Books Inventory</span></a>
                </div>
            </div>

        </div>

        <div class="main-dash">
            <div class="nav-dash"> 
                <div class="logo">
                    <img src="assets/booked.png">
                    <span>Dashboard</span>
                </div>
                
                <div class="logout">
    <a href="#" onclick="confirmLogout()" style="font-size: 20px;">
        <img src="assets/logout.png" style="height:30px; width: 30px; margin:10px 0 0 900px;">
    </a>
</div>

            </div>

            <div class="total">
                <div class="tot">
                    <img src="assets/male-student.png" style="height:50px;width: 50px;">
                    <div class="tot-num"><?php echo $total_students; ?></div>
                    <span>Total Students</span>
                </div> 

                <div class="tot">
                    <img src="assets/teacher.png" style="height:50;width: 50px;">
                    <div class="tot-num"><?php echo $total_instructors; ?> </div>
                    <span>Total Instructors</span>
                </div>

                <div class="tot">
                    <img src="assets/av-books.png" style="height:50px;width: 50px;">
                    <div class="tot-num">20</div>
                    <span>Available Books</span>
                </div>
                    
                <div class="tot">
                    <img src="assets/bor.png" style="height: 50px;width:50px;">
                    <div class="tot-num">10</div>
                    <span>Borrowed Books</span>
                </div>

                <div class="tot">
                    <img src="assets/return.png" style="height:50px;width:50px;">
                    <div class="tot-num">12</div>
                    <span>Returned Books</span>
                </div>
            </div>

            <div id="calendar-container">
                <div id="calendar-header">
                    <button id="prev-month">&lt;</button>
                    <h2 id="month-year"></h2>
                    <button id="next-month">&gt;</button>
                </div>
                <table id="calendar">
                    <thead>
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body">
                        <!-- Calendar dates will be injected here -->
                    </tbody>
                </table>
            </div>
            <script src="html/script.js"></script>

        
            <script>
                function confirmLogout() {
                    if (confirm("Are you sure you want to logout?")) {
                        window.location.href = "login.php";
                    }
                }
            </script>
        </div>
    </div>
</body>
</html>