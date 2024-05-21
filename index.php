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
        <li><a href="index.php" class="">Home</a></li>
        <li><a href="Schedule.php">Schedule</a></li>
        <li><a href="chat.php">Chat</a></li>
        <li><a href="Account.php">Account</a></li>
        <li class="dropdown"><a href="#"><span>Favourites</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
             <ul>
            <?php
            $conn = mysqli_connect("localhost", "root", "", "funolympics");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $user_id = $_SESSION['user_id'];
            $favorites_sql = "SELECT sport_name FROM user_favorites WHERE user_id = '$user_id'";
            $favorites_result = mysqli_query($conn, $favorites_sql);
            while ($row = mysqli_fetch_assoc($favorites_result)) {
                // Each sport is a link to the sport's information page
                echo '<li><a href="sport_info.php?sport=' . urlencode($row['sport_name']) . '">' . $row['sport_name'] . '</a></li>';
            }
            mysqli_close($conn);
            ?>
        </ul>
        </li>
        <li><a href="index.php#contact">Contact</a></li>
        <li><a href="register.html">Create Account</a></li>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>
      <a class="btn-getstarted" href="logout.php">LOG OUT</a>
    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <img src="Images/bolt.jpg" alt="" data-aos="fade-in">
      <div class="container">
        <div class="row">
          <div class="col-lg-10">
            <h1>Welcome, <?php echo $_SESSION['user_name']; ?>!, <?php echo $_SESSION['user_id']; ?>!</h1>
            
            <p data-aos="fade-up" data-aos-delay="200">"Where Every Moment Sparks a Victory!"</p>
          </div>
          <div class="col-lg-5">
            <form action="#" class="sign-up-form d-flex" data-aos="fade-up" data-aos-delay="300">
              <input type="text" class="form-control" placeholder="Search Sports Events">
              <input type="submit" class="btn btn-primary" value="Search">
            </form>
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->

  <section id="recommendation" class="recommendation section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Recommendations</h2>
    <p>Keep up-to date with the latest news and recieve live updates</p>
  </div>
      
  <div id="sportsCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner" style="height: 500px;"> <!-- Reduced height of carousel -->
      <?php
      // Connect to the database
      $conn = mysqli_connect("localhost", "root", "", "funolympics");

      // Check connection
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }

      // Query to fetch sports information
      $sql = "SELECT name, date, image FROM sports";
      $result = mysqli_query($conn, $sql);

      // Query to fetch user favorites
      $user_id = $_SESSION['user_id'];
      $favorites_sql = "SELECT sport_name FROM user_favorites WHERE user_id = '$user_id'";
      $favorites_result = mysqli_query($conn, $favorites_sql);
      $favorites = [];
      while ($row = mysqli_fetch_assoc($favorites_result)) {
          $favorites[] = $row['sport_name'];
      }

      // Check if there are any records
      if (mysqli_num_rows($result) > 0) {
        $active = true;
        // Loop through each row
        while ($row = mysqli_fetch_assoc($result)) {
          $is_favorite = in_array($row['name'], $favorites);
          ?>
          <div class="carousel-item <?php if ($active) { echo 'active'; $active = false; } ?>">
  <div class="card text-center" style="width: 30rem; margin-left: auto; margin-right: auto;"> <!-- Reduced width of card -->
    <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
    <div class="card-body" style="display: flex; justify-content: space-between; align-items: center;">
      <!-- Title and description -->
      <div>
        <h5 class="card-title"><?php echo $row['name']; ?></h5>
        <p class="card-text"><?php echo $row['date']; ?></p>
      </div>
      <button class="btn btn-primary notify-btn <?php if ($is_favorite) echo 'red'; ?>" data-sport="<?php echo $row['name']; ?>" onclick="notifyUser('<?php echo $row['name']; ?>', this)" style="border-radius: 5px; width: 40px; height: 40px;">
  <i class="bi bi-bell" style="font-size: 20px;"></i>
</button>
    </div>
  </div>
</div>

          <?php
        }
      } else {
        echo "No sports found";
      }
      // Close database connection
      mysqli_close($conn);
      ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#sportsCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#sportsCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
      
      
</section>
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
