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
    // Get form data
    $sport_id = $_POST['sport_id'];
    $youtube_link = $_POST['youtube_link'];

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO youtube_links (sport_id, youtube_link) VALUES (?, ?)");
    $stmt->bind_param("is", $sport_id, $youtube_link);

    if ($stmt->execute()) {
        echo "YouTube link added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
