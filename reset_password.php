<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "funolympics";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $conn->real_escape_string($_POST["token"]);
    $new_password = $conn->real_escape_string($_POST["new_password"]);

    // Validate token
    $sql = "SELECT * FROM password_resets WHERE token = '$token' AND expiry > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row["email"];

        // Update password in users table
        $update_sql = "UPDATE users SET password = '$new_password' WHERE email = '$email'";
        if ($conn->query($update_sql) === TRUE) {
            // Delete the token from password_resets table
            $delete_sql = "DELETE FROM password_resets WHERE email = '$email'";
            $conn->query($delete_sql);
            // Redirect to login page after successful password reset
            header("Location: login.html");
            exit();
        } else {
            echo "Failed to update password.";
        }
    } else {
        echo "Invalid or expired token.";
    }
}

// Close connection
$conn->close();
?>
