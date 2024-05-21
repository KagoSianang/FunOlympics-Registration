<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] === true) {
    // If logged in, display the user's name
    echo "Welcome, " . $_SESSION["username"];
} else {
    // If not logged in, redirect to the login page
    header("Location: Append/index.html");
    exit();
}
?>