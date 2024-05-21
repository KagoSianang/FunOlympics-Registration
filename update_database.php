<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include database connection
    include 'database_connection.php';

    // Get user input
    $name = htmlspecialchars($_POST['name']);
    $country = htmlspecialchars($_POST['country']);
    $email = htmlspecialchars($_POST['email']);
    $contact = htmlspecialchars($_POST['contact']);

    // Validate input (additional validation can be added as needed)
    if (empty($name) || empty($country) || empty($email) || empty($contact)) {
        // Handle the error appropriately
        $_SESSION['update_success'] = false;
        header("Location: user_information.php");
        exit();
    }

    // Assume user_id is stored in session
    $user_id = $_SESSION['user_id'];

    // Update the database
    $sql = "UPDATE users SET name = ?, country = ?, email = ?, contact = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $country, $email, $contact, $user_id);

    if ($stmt->execute()) {
        // Update session variables
        $_SESSION['user_name'] = $name;
        $_SESSION['user_country'] = $country;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_contact'] = $contact;

        // Set success message
        $_SESSION['update_success'] = true;
    } else {
        $_SESSION['update_success'] = false;
    }

    // Close connection
    $stmt->close();
    $conn->close();

    // Redirect back to the form
    header("Location: user_information.php");
    exit();
} else {
    // If the request method is not POST, redirect to the form
    header("Location: user_information.php");
    exit();
}
?>
