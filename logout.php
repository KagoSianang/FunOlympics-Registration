<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page or any other appropriate page
header("Location: index.php"); // Change 'login.php' to your actual login page
exit;
?>
