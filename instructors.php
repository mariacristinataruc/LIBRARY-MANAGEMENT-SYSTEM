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

// Function to generate custom ID
function generateCustomID($conn) {
    $prefix = "INST";
    $datePart = date("ym");
    $randomNumber = mt_rand(100, 999);

    // Create the custom ID
    $customID = "$prefix$datePart$randomNumber";

    // Ensure the custom ID is unique in the database
    $sql = "SELECT inst_ID FROM instructors WHERE inst_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $customID);
    $stmt->execute();
    $stmt->store_result();

    // If the ID already exists, generate a new one
    if ($stmt->num_rows > 0) {
        $stmt->close();
        return generateCustomID($conn);
    }

    $stmt->close();
    return $customID;
}

// Retrieve form data via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $dept = $_POST['dept'] ?? '';
    $email = $_POST['email'] ?? '';
    $pnum = $_POST['pnum'] ?? '';
    $stname = $_POST['stname'] ?? '';

    // Debugging output
    echo "Received form data:<br>";
    echo "First Name: $fname<br>";
    echo "Last Name: $lname<br>";
    echo "course: $dept<br>";
    echo "Email: $email<br>";
    echo "Phone Number: $pnum<br>";
    echo "Admin Name: $stname<br>";

    if (!empty($fname) && !empty($lname) && !empty($dept) && !empty($email) && !empty($pnum) && !empty($stname)){
        // Generate custom ID
        $customID = generateCustomID($conn);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO instructors (inst_ID, inst_fname, inst_lname, inst_dept, inst_email, inst_pnum, as_ID) VALUES ( ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssssis", $customID, $fname, $lname, $dept, $email, $pnum, $stname);

            // Execute statement
            if ($stmt->execute()) {
                // Redirect to the same page to avoid form resubmission on refresh
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "Error: " . $stmt->error . "<br>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error . "<br>";
        }
    } else {
        echo "Error: Form data is incomplete<br>";
    }
}

// Count total entries in admin-staff table
$total_entries_sql = "SELECT COUNT(*) as total FROM `instructors`";
$total_entries_result = $conn->query($total_entries_sql);
$total_entries = 0;

if ($total_entries_result->num_rows > 0) {
    $total_entries_row = $total_entries_result->fetch_assoc();
    $total_entries = $total_entries_row['total'];
}


// Retrieve and display records in HTML table
$sql = "SELECT inst_ID, CONCAT(inst_fname, ' ', inst_lname) AS full_name, inst_dept, inst_email, inst_pnum, as_ID FROM `instructors` ORDER BY inst_fname DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructors</title>
    <link rel="shortcut icon" href="assets/professor.png">
    <link rel="stylesheet" href="css/instruct-style.css">
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


.main-dash {
    height: 700px; /* Adjust this height as needed */
    overflow-y: auto;
    padding: 0; /* Optional: Adds padding around the content */
    box-sizing: border-box; /* Ensures padding is included in the total height */
    overflow-x:hidden;
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
    color:black;
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
    height:700px;
    margin: 7px 7px;
    border-radius: 10px;
    left: 259px;
    background-color: #F7F1E5;

  }

  .search{
    position: absolute;
    width:300px;
    height:40px;
    margin: 10px 0 0 650px;
    background-color:white;
    border-radius: 10px;
  }

  .sear{
    position: absolute;
    width:250px;
    height:30px;
    border-radius: 10px;
    background-color: white;
    border: none;
    margin: 4px;
  } 

  .search img{
    margin: 8px 20px 0 265px;
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
    position: absolute;
    display: grid;
    justify-content: space-evenly;
    height:130px; 
    width:970px;
    margin: 70px 0;
    align-items: center;
    font-size: small;
    text-align: center;
  }

  .ent{
    height: 20px;
    width:70px;
    margin-top: 5px;
    background-color: #FFE188;
    border:none;
  }

  .enter{
    position: absolute;
    height: 35px;
    width:100px;
    background-color: #FFE188;
    border-radius: 10px;
  }

  .entry-add{
    position:absolute;
    height:70px;
    width:100px;
    margin:60px 10px 70px 700px;
    
  }

  .add-new{
    position: absolute;
    height:35px;
    width:120px;
    left:120px;
    border-radius: 10px;
    background-color: #898121;
  }

  .add-new button{
    position:relative;
    height:35px;
    width:120px;
    background-color: #E7B10A;
    border-radius: 10px;
    padding-left: 30px;
    border:none;
  }

  .add-new button:hover{
  position:relative;
  height:35px;
  width:120px;
  background-color: #E7B10A;
  border-radius: 10px;
  padding-left: 30px;
  border:none;
  background: linear-gradient(#E7B10A, #898121);
}

  .add-new button img{
    position:absolute;
    top:5px;
    left:10px;
    height: 25px;
    width: 25px;
  }
  
  
/*this is under the tabular section*/
.tabular{
  position: relative;
  background: white;
  margin-top: 130px;
  border-radius:10px;
  padding:1rem;
}
/*style for the table*/
.table{
  border-radius: 10px;
  width:950px;
  height: auto;
}
/*style of table*/
table{
  width:950px;
  height: auto;
  border-collapse: collapse;
  margin-top:100px;
}
/*style on the table head*/
thead{
  background:linear-gradient(#efcc62,#ece16f); 
  color: black
}
/*style on the table head*/
th{
  padding:10px;
  text-align:left;
}
/*style on the table body*/
tbody{
  background:#FFF2F2;
  
}
/*style on the table data*/
td{
  padding: 8px;
  font-size: 12px;
  color: #333;
  text-align:left;
}
/*Set background color to white for every even-numbered row 
in an HTML table to create alternating row colors.*/
tr:nth-child(even){
  background:white;
}
/*style on table foote, set background color and its text*/
tfoot{
  background:linear-gradient(#efcc62,#ece16f); 
  color: black;
  font-weight: bold;
}
/*style table footer and table data*/
tfoot td{
  padding:15px;
  text-align: center;
  color: black;
}
/*style on button under the table*/
.table button{
  background:none;
  cursor:pointer;
  padding:4px;
  margin:8px 0;
  border-radius:8px;
  border: none;
  transition: all 0.1s ease-in-out;
}
/*set effect on button under table, and set highlight color */
.table button:hover,
.active {
  background:#4F6F52;
}
/*set the span of the button in the table*/
.table button span{
 width: 10px;
}

.staff-admin:hover{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
    margin: 55px 0 0 0;
    background: linear-gradient(#898121,#E7B10A);
  }

  .dashboard:hover{
    position: absolute;
    height:45px;
    width:240px;
    border-radius: 10px;
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

  .input span{
  font-weight:700;color: #1A4D2E;text-shadow: 0 2px 3px #F5EFE6;
  }

    </style>
<body>
    
    <div class="whole-main">
        <div class="menu-bar">
        <div class="admin">
                <img src="assets/admin.png" style="height: 50px;width: 50px;"><br>
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
                    <span>Instructors</span>
                </div>

                <div class="search">
                    <input type="text" placeholder="search" class="sear">
                    <img src="assets/search.png" style="height: 25px;width: 25px;">
                </div>

            </div>

            <form action="instructor-new.php" method=GET>
            <div class="total">
                <div class="entry-add">
                    <span>TOTAL ENTRY</span>

                    <div class="enter">
                    <input type="text" value="<?php echo $total_entries; ?>" class="ent" readonly>
                    </div>
                
                    <div class="add-new">
                        <a href="#" class="add"><button><span><img src="assets/add.png">ADD NEW</span></button></a>
                    </div>
                </form>
        </div>
                    

</body>
</html>
<?php
if ($result->num_rows > 0) {
    // Output data in HTML table
    echo "<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Department</th> 
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Action</th>
                </tr>
            </thead>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["inst_ID"] . "</td>
                <td>" . $row["full_name"] . "</td>
                <td>" . $row["inst_dept"] . "</td>
                <td>" . $row["inst_email"] . "</td>
                <td>" . $row["as_ID"] . "</td>
                <td>
                    <a href='instructor-update.php?id=" . $row["inst_ID"] . "'>
                        <img src='assets/edit.png' style='width: 20px;height: 20px;'>
                    </a> 
                    <a href='instructor-view.php?id=" . $row["inst_ID"] . "'>
                        <img src='assets/vision.png' style='width: 20px;height: 20px;'>
                    </a>
                    <a href='instructor-delete.php?id=" . $row["inst_ID"] . "' onclick=\"return confirm('Are you sure you want to delete this record?');\">
                        <img src='assets/del.png' style='width: 20px;height: 20px;'>
                    </a>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "0 results<br>";
}

$conn->close();
?>
