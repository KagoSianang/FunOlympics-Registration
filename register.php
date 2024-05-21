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
    $token = $_POST["token"];
    $new_password = $conn->real_escape_string($_POST["new_password"]);

    // Validate token
    $sql = "SELECT * FROM password_resets WHERE token = '$token' AND expiry > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row["email"];

        // Update password in users table
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
        if ($conn->query($update_sql) === TRUE) {
            // Delete the token from password_resets table
            $delete_sql = "DELETE FROM password_resets WHERE email = '$email'";
            $conn->query($delete_sql);
            echo "Your password has been reset successfully.";
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
