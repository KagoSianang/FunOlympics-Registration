<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Home - FunOlympics</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="Images/logo.png" rel="icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.css" rel="stylesheet">

  <link href="assets/css/main.css" rel="stylesheet">

 <style>
  .recommendation {
    background-color: black; /* Set the background color to black */
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
  
</style>


</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">FunOlympics</h1><span>.</span>
      </a>
      <!-- Main menu -->
    <nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="visitor.php" class="">Home</a></li>
        <li><a href="visitor_schedule.php">Schedule</a></li>
        <li><a href="index.php#contact">Contact</a></li>
        <li><a href="register.html">Create Account</a></li>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>
      <a class="btn-getstarted" href="login.html">LOGIN</a>
    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <img src="Images/bolt.jpg" alt="" data-aos="fade-in">
      <div class="container">
        <div class="row">
          <div class="col-lg-10">
            <h1>Welcome
            
            <p data-aos="fade-up" data-aos-delay="200">"Where Every Moment Sparks a Victory!"</p>
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->

  
<!-- End Recommendation Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->
      <!-- Contact form and info here -->
    </section><!-- /Contact Section -->

  </main>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  

<script>
function notifyUser(sport, button) {
    $.ajax({
        type: "POST",
        url: "update_favorites.php",
        data: { sport: sport },
        success: function(response) {
            if (response.trim() === "Favorite updated successfully") {
                // Change button color to red by adding a class
                $(button).addClass("red");
                // Show success message
                alert("Sport added to favorites!");
            } else if (response.trim() === "Favorite removed successfully") {
                // Change button color to green by removing the class
                $(button).removeClass("red");
                // Show success message
                alert("Sport removed from favorites!");
            } else {
                console.error("Error:", response);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
        }
    });
}
</script>

</body>
</html>
