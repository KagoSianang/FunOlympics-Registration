<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "funolympics");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['sport'])) {
    $sport = $_POST['sport'];
    $user_id = $_SESSION['user_id'];
    
    // Check if the sport is already a favorite
    $check_sql = "SELECT * FROM user_favorites WHERE user_id = '$user_id' AND sport_name = '$sport'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Remove from favorites
        $delete_sql = "DELETE FROM user_favorites WHERE user_id = '$user_id' AND sport_name = '$sport'";
        if (mysqli_query($conn, $delete_sql)) {
            echo "Favorite removed successfully";
        } else {
            echo "Error removing favorite: " . mysqli_error($conn);
        }
    } else {
        // Add to favorites
        $insert_sql = "INSERT INTO user_favorites (user_id, sport_name) VALUES ('$user_id', '$sport')";
        if (mysqli_query($conn, $insert_sql)) {
            echo "Favorite updated successfully";
        } else {
            echo "Error adding favorite: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
