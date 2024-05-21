<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link href="Images/logo.png" rel="icon">
    <title>AdminLogin</title>
    <link href="Images/logo.png" rel="icon">
</head>
<body background="Images/Paris.jpeg">
    
    <div class="login-container">
        <h2>Fun Olympics</h2>
        <h2>Admin Login</h2>
        <img src="Images/logo.png" alt="Sports Logo" class="logo">
        <form action="Admin.php" method="POST">
            <div class="input-container">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your Email" required>
            </div>
            <div class="input-container">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <input type="submit" value="Login">
        </form>
        <!-- Button to switch to user login page -->
        <form action="login.html" class="switch-button">
            <input type="submit" value="User Login">
        </form>
    </div>
</body>
<!-- Add this code to your admin login page -->
<script>
    // Check if the login error message is set
    <?php if(isset($_SESSION['login_error'])): ?>
        // Show a popup with the error message
        alert("<?php echo $_SESSION['login_error']; ?>");
        // Clear the login error message from the session
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>
</script>

</html>