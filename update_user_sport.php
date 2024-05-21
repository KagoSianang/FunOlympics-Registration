<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the sport name from the request
    $sportName = $_POST['sport'];

    // Update the user's database with the sport name
    $userId = $_SESSION['user_id']; // Assuming you have user ID stored in session

    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "funolympics");

    // Check connection
    if (!$conn) {
        // Database connection error
        $data = array('success' => false, 'message' => 'Database connection failed: ' . mysqli_connect_error());
        echo json_encode($data);
        exit; // Stop further execution
    }

    // Update user's sport in the database
    $sql = "UPDATE users SET sport = '$sportName' WHERE id = '$userId'";
    if (mysqli_query($conn, $sql)) {
        // Database updated successfully
        $data = array('success' => true);
        echo json_encode($data);
    } else {
        // Error updating database
        $data = array('success' => false, 'message' => 'Error updating database: ' . mysqli_error($conn));
        echo json_encode($data);
    }

    // Close database connection
    mysqli_close($conn);
} else {
    // Invalid request method
    $data = array('success' => false, 'message' => 'Invalid request method');
    echo json_encode($data);
}
?>
