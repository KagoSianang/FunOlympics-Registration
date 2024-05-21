<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = mysqli_connect("localhost", "root", "", "funolympics");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Set the sender type to "admin"
    $sender_type = "admin";

    // Escape user input to prevent SQL injection
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Check if the message is not empty
    if (!empty($message)) {
        // Insert the message into the database
        $sql = "INSERT INTO chat_app (user_name, message, sender_type) VALUES ('Admin', '$message', '$sender_type')";

        if (mysqli_query($conn, $sql)) {
            // Redirect back to the appropriate page based on the sender type
            if ($_SESSION['admin_logged_in']) {
                header("Location: admenu.php");
            } else {
                header("Location: admin.php");
            }
            exit(); // Terminate script after redirection
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        // Handle empty message case
        echo "Error: Message cannot be blank.";
    }

    mysqli_close($conn);
}
?>
