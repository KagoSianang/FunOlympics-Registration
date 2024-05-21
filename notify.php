<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  echo json_encode(['success' => false, 'message' => 'User not logged in']);
  exit;
}

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['sport'])) {
  echo json_encode(['success' => false, 'message' => 'No sport specified']);
  exit;
}

$sport = $data['sport'];
$userId = $_SESSION['user_id'];

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "funolympics");
if (!$conn) {
  echo json_encode(['success' => false, 'message' => 'Database connection failed']);
  exit;
}

// Check if the sport already exists in the user's notifications
$sql = "SELECT sports FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $existingSports);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$existingSportsArray = explode(',', $existingSports);
if (in_array($sport, $existingSportsArray)) {
  echo json_encode(['success' => false, 'message' => 'Sport already in notifications']);
  exit;
}

// Add the new sport to the list
$updatedSports = $existingSports ? $existingSports . ',' . $sport : $sport;

// Update the user's notifications in the database
$sql = "UPDATE users SET sports = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'si', $updatedSports, $userId);
if (mysqli_stmt_execute($stmt)) {
  echo json_encode(['success' => true, 'message' => 'Notification saved']);
} else {
  echo json_encode(['success' => false, 'message' => 'Failed to save notification']);
}
mysqli_stmt_close($stmt);

// Close database connection
mysqli_close($conn);
?>
