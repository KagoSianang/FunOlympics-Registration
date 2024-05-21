<?php
// Start the session
session_start();

// Include database connection
include('db_connection.php');

// Fetch messages from the database
$sql = "SELECT * FROM chat_app ORDER BY timestamp ASC LIMIT 50"; // Limit to latest 50 messages
$result = mysqli_query($conn, $sql);

// Construct HTML for messages
$messages_html = '';
while ($row = $result->fetch_assoc()) {
    // Escape output to prevent XSS
    $user_name = htmlspecialchars($row['user_name']);
    $message = htmlspecialchars($row['message']);
    $timestamp = htmlspecialchars($row['timestamp']);
    // Check if the message is sent by the active user
    $is_active_user = ($_SESSION['user_name'] == $user_name);
    // Add classes based on whether the message is from the active user or not
    $message_classes = $is_active_user ? 'active-user' : 'inactive-user';
    $messages_html .= '<div class="chat-message ' . $message_classes . '"><div class="timestamp">' . $timestamp . '</div><strong>' . $user_name . ':</strong> ' . $message . '</div>';
}

// Close database connection
mysqli_close($conn);

// Return messages HTML
echo $messages_html;
?>
