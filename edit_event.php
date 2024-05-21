<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.html");
    exit();
}

// Database connection details
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $sport = $conn->real_escape_string($_POST['sport']);
    $date = $conn->real_escape_string($_POST['date']);
    $time = $conn->real_escape_string($_POST['time']);
    $venue = $conn->real_escape_string($_POST['venue']);
    
    $sql = "UPDATE schedule SET sport = '$sport', date = '$date', time = '$time', venue = '$venue' WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboard.php#edit-event");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
