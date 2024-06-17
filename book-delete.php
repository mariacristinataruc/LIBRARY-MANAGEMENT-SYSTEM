<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library-ms";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"];

    // Delete the record
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "DELETE FROM `book-info` WHERE b_ID='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: books.php");
        echo "Record deleted successfully";
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $conn->close();
}
?>
