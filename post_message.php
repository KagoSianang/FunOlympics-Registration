<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = mysqli_connect("localhost", "root", "", "funolympics");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $user_name = mysqli_real_escape_string($conn, $_SESSION['user_name']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO chat_app (user_name, message) VALUES ('$user_name', '$message')";

    if (mysqli_query($conn, $sql)) {
        header("Location: chat.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
