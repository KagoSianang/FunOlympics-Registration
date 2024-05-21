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
    $sport = $_POST['sport'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = $_POST['venue'];

    // Use prepared statements to insert event details into the database
    $stmt = $conn->prepare("INSERT INTO schedule (sport, date, time, venue) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $sport, $date, $time, $venue);

    if ($stmt->execute()) {
        echo "Event added successfully";
    } else {
        echo "Error adding event: " . $stmt->error;
    }

    $stmt->close();

    header("Location: admenu.php");
    exit();
}

$conn->close();
?>
