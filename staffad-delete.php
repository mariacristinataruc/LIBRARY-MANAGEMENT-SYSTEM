<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library-ms";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Fetch the ur_ID for the given admin-staff ID
        $stmt = $conn->prepare("SELECT ur_ID FROM `admin-staff` WHERE as_ID = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($ur_ID);
        $stmt->fetch();
        $stmt->close();

        // Delete the record from the admin-staff table
        $stmt = $conn->prepare("DELETE FROM `admin-staff` WHERE as_ID = ?");
        $stmt->bind_param("s", $id);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $stmt->close();

        // Delete the record from the user-roles table
        $stmt = $conn->prepare("DELETE FROM `user-roles` WHERE ur_ID = ?");
        $stmt->bind_param("s", $ur_ID);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $stmt->close();

        // Commit transaction
        $conn->commit();

        echo "Record deleted successfully";
        header("Location: staff-admin.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo "Error deleting record: " . $e->getMessage();
    }

    $conn->close();
}
?>
