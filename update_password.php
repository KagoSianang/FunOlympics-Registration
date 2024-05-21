<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "funolympics";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Check if the token is valid and not expired
        $sql = "SELECT * FROM password_resets WHERE token='$token' AND expiry > NOW()";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];

            // Update the user's password
            $sql = "UPDATE users SET password='$hashedPassword' WHERE email='$email'";
            if ($conn->query($sql) === TRUE) {
                // Delete the token
                $sql = "DELETE FROM password_resets WHERE token='$token'";
                $conn->query($sql);
                echo "Password has been reset successfully.";
            } else {
                echo "Failed to update password.";
            }
        } else {
            echo "Invalid or expired token.";
        }
    } else {
        echo "Passwords do not match.";
    }
}

$conn->close();
?>
