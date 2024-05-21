<?php
session_start();

// Default language is English
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Check if a language has been selected
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Include the selected language file
$lang_file = 'lang/' . $_SESSION['lang'] . '.php';
if (file_exists($lang_file)) {
    include($lang_file);
} else {
    include('en.php');
}
$current_page = basename($_SERVER['PHP_SELF']);

$page_urls = array(
    'index.php' => 'Home',
    'Schedule.php' => 'Schedule',
    'chat.php' => 'Chat',
    'Account.php' => 'Account',
    // Add more page URLs as needed
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Chat - FunOlympics</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="Images/logo.png" rel="icon">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Montserrat:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <style>
        .recommendation {
            background-color: black;
            color: white;
            padding: 40px 0;
        }

        .notify-btn {
            background-color: red !important;
        }

        .notify-btn.red {
            background-color: greenyellow !important;
        }

        .notify-btn:hover {
            background-color: yellow !important;
        }

        .chat-box {
            width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: white;
        }

        .chat-message {
    margin-bottom: 10px;
    color: black; /* Change text color to black */
}
.timestamp {
    color: gray; /* Timestamp color */
    font-size: 12px; /* Adjust font size */
    margin-bottom: 5px; /* Add some spacing */
}

.chat-message.active-user {
    text-align: right; /* Align left */
    background-color: #f2f2f2; /* Background color for active user's messages */
    border-radius: 15px; /* Rounded corners */
    padding: 10px 15px; 
    background-color: greenyellow;
}

.inactive-user {
     text-align: left; /* Align left */
    background-color: white; /* Background color for active user's messages */
    border-radius: 15px; /* Rounded corners */
    padding: 5px 15px; 
    background-color: skyblue 
}
    </style>
    <script>
        $(document).ready(function() {
            function loadMessages() {
                $.ajax({
                    url: 'get_messages.php',
                    method: 'GET',
                    success: function(data) {
                        $('#chat-messages').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + error);
                    }
                });
            }

            loadMessages(); // Initial load

            setInterval(loadMessages, 3000); // Refresh every 3 seconds
        });
    </script>
</head>

<body class="index-page">

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
            <h1 class="sitename">FunChat</h1><span>.</span>
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="index.php" class="">Home</a></li>
                <li><a href="Schedule.php">Schedule</a></li>
                <li><a href="chat.php">Chat</a></li>
                <li><a href="Account.php">Account</a></li>
                <li class="dropdown"><a href="#"><span>Favourites</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
                <?php
                // Fetch and display user's favorites
                $conn = mysqli_connect("localhost", "root", "", "funolympics");
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $user_id = $_SESSION['user_id'];
                $favorites_sql = "SELECT sport_name FROM user_favorites WHERE user_id = '$user_id'";
                $favorites_result = mysqli_query($conn, $favorites_sql);
                while ($row = mysqli_fetch_assoc($favorites_result)) {
                    echo '<li><a href="#">' . $row['sport_name'] . '</a></li>';
                }
                mysqli_close($conn);
                ?>
            </ul>
        </li>
                <li><a href="index.php#contact">Contact</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <a class="btn-getstarted" href="logout.php">LOG OUT</a>
    </div>
</header>

<main class="main">
    <section id="hero" class="hero section">
        <img src="Images/chat.webp" alt="Chat Background">
        <div class="container">
            <div class="chat-box">
                <h2>Chat Box</h2>
                <div id="chat-messages">
                    <!-- Messages will be loaded here by AJAX -->
                </div>
                <form action="post_message.php" method="POST">
                    <label for="user_name">Your Name:</label><br>
                    
                    <label for="message">Message:</label><br>
                    <textarea id="message" name="message" required></textarea><br><br>
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </section>
</main>


<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/js/main.js"></script>

<script>
$(document).ready(function() {
    function loadMessages() {
        $.ajax({
            url: 'get_messages.php',
            method: 'GET',
            success: function(data) {
                $('#chat-messages').html(data);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    }

    loadMessages(); // Initial load

    // Refresh messages every 3 seconds
    setInterval(loadMessages, 3000);
});
</script>


</body>
</html>
