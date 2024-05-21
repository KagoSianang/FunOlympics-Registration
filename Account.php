<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Information</title>
<link rel="stylesheet" href="style/acc.css">
<link href="Images/logo.png" rel="icon">
<style>
    .back-button {
        position: absolute;
        left: 10px;
        top: 10px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        padding: 8px;
        border-radius: 5px;
        text-decoration: none;
    }

    .back-button:hover {
        background-color: #e0e0e0;
    }

    .back-arrow {
        width: 0;
        height: 0;
        border-top: 8px solid transparent;
        border-bottom: 8px solid transparent;
        border-right: 12px solid black;
        display: inline-block;
        margin-right: 8px;
    }
</style>
</head>
<body background="Images/acc.jpeg">

<a href="index.php" class="back-button">
    <span class="back-arrow"></span>
    Back
</a>

<div class="login-container">
    <form id="userInfoForm" method="post" action="update_database.php">
        <h2>Edit Your Information</h2>
        <div class="input-container">
            <div class="input-field">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $_SESSION['user_name']; ?>" required>
            </div>
            <div class="input-field">
                <label for="country">Country:</label>
                <input type="text" id="country" name="country" value="<?php echo $_SESSION['user_country']; ?>" required>
            </div>
        </div>
        <div class="input-container">
            <div class="input-field">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $_SESSION['user_email']; ?>" required>
            </div>
            <div class="input-field">
                <label for="contact">Contact:</label>
                <input type="text" id="contact" name="contact" value="<?php echo $_SESSION['user_contact']; ?>" required>
            </div>
        </div>
        
  
        <input type="submit" name="save_changes" value="Save Changes">
    </form>
</div>
<?php
    // Check if the update was successful
    if (isset($_SESSION['update_success']) && $_SESSION['update_success']) {
        echo '<script>alert("Account was successfully updated!");</script>';
        // Reset the session variable
        $_SESSION['update_success'] = false;
    }
?>
</body>
</html>
