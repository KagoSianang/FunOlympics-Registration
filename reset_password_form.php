<?php
$token = $_GET['token'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link href="Images/logo.png" rel="icon">
    <title>Reset Password</title>
</head>
<body background="Images/Paris.jpeg">
    <div class="login-container">
        <h2>Reset Password</h2>
        <form action="reset_password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="input-container">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" placeholder="Enter your new password" required>
            </div>
            <input type="submit" value="Reset Password">
        </form>
    </div>
</body>
</html>
