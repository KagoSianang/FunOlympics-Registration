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

// Check if token is provided in the URL
if (isset($_GET['token'])) {
    $token = $conn->real_escape_string($_GET['token']);
    
    // Query the database to find the user with the given token
    $sql = "SELECT * FROM pending_users WHERE verification_token = '$token'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, retrieve user data
        $user = $result->fetch_assoc();
        $name = $user['name'];
        $country = $user['country'];
        $email = $user['email'];
        $password = $user['password'];
        $contact = $user['contact'];

        // Insert user into 'users' table
        $insert_user_sql = "INSERT INTO users (name, country, email, password, contact)
                            VALUES ('$name', '$country', '$email', '$password', '$contact')";
        if ($conn->query($insert_user_sql) === TRUE) {
            // Delete the user from 'pending_users' table
            $delete_pending_sql = "DELETE FROM pending_users WHERE verification_token = '$token'";
            $conn->query($delete_pending_sql);

            echo "Your email has been verified and your registration is complete.";
        } else {
            echo "Error: " . $insert_user_sql . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid verification token.";
    }
} else {
    echo "No verification token provided.";
}

// Close connection
$conn->close();
?>
