<?php
// Start session
session_start();

// Database connection
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

// Retrieve email and password from the form (ensure they're sanitized to prevent SQL injection)
$email = $conn->real_escape_string($_POST['email']);
$password = $conn->real_escape_string($_POST['password']);

// SQL query to check if the email and password match any user
$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
$result = $conn->query($sql);

// Debugging: Check if the query executed successfully
if (!$result) {
    echo "Error executing query: " . $conn->error;
    exit();
}

// If a match is found, start a session and store relevant user information
if ($result && $result->num_rows == 1) {
    // Fetch user details
    $user = $result->fetch_assoc();
    
    // Debugging: Print user data for verification
    echo "<pre>";
    print_r($user);
    echo "</pre>";

    // Store user information in session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_name'] = $user['Name'];
    $_SESSION['user_country'] = $user['Country'];
    $_SESSION['user_password'] = $user['Password'];
    $_SESSION['user_contact'] = $user['Contact'];
    
    // You can store more user information if needed

    // Redirect to dashboard or any other desired page
    header("Location: index.php");
    exit();
} else {
    // If no match is found, redirect back to the login page with an error message
    $_SESSION['login_error'] = "Invalid email or password";
    header("Location: login.html");
    exit();
}

$conn->close();
?>
