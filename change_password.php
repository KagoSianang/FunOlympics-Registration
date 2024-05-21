<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "funolympics";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $new_password = $_POST['new_password'];

    // Debugging: Log the received inputs
    error_log("Received user_id: " . $user_id);
    error_log("Received new_password: " . $new_password);

    // Check if the new_password is not empty
    if (empty($new_password)) {
        die("Password field cannot be empty.");
    }

    // Use prepared statements to update the password
    $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
    $stmt->bind_param("si", $new_password, $user_id);

    if ($stmt->execute()) {
        echo "Password updated successfully";
    } else {
        echo "Error updating password: " . $stmt->error;
    }

    $stmt->close();

    header("Location: admenu.php");
    exit();
}

$conn->close();
?>
