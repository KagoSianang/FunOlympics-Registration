<?php
session_start();

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "funolympics";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the database
$sql = "SELECT sport, date, time, venue FROM schedule";
$result = $conn->query($sql);

// Close the connection (optional)
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="Images/logo.png" rel="icon">
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Home- FunOlympics</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/fun.jpg" rel="icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link href="assets/css/schedule.css" rel="stylesheet">
  
    <style>
        /* Body styles */
        body {
            margin: 0;
            padding: 10px;
            background-color: #f3f3f3; /* Light gray background */
        }

        /* Grid background */
        .grid-background {
            background-image: linear-gradient(rgba(255, 255, 255, 0.2) 1px, transparent 100px), linear-gradient(90deg, rgba(255, 255, 255, 0.2) 1px, transparent 1px);
            background-size: 20px 20px;
            height: 100vh;
        }

        /* Container styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Table layout for events */
        .event-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px; /* Increased margin */
        }

        /* Table header styles */
        .event-table th {
            background-color: #f9f9f9; /* Light gray background */
            padding: 15px; /* Increased padding */
            text-align: left;
            font-size: 18px;
            color: #333;/* Increased font size */
        }

        /* Table cell styles */
        .event-table td {
            border: 1px solid #ddd; /* Light gray border */
            padding: 15px; /* Increased padding */
            font-size: 16px; /* Increased font size */
            background-color: #fff; /* White background */
            color: #333; /* Dark text color */
        }
        .asc::after {
            content: "▲";
            color: green;
        }

        .desc::after {
            content: "▼";
            color: red;
        }
    </style>

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">

        <h1 class="sitename">Schedule</h1><span>.</span>
      </a>

      <!-- Main menu -->
         <nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="visitor.php" class="">Home</a></li>
        <li><a href="visitor_Schedule.php">Schedule</a></li>
        <li><a href="index.php#contact">Contact</a></li>
        <li><a href="register.html">Create Account</a></li>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>


      <a class="btn-getstarted" href="index.php#about">LOG OUT</a>

    </div>
  </header>

     <header id="header" class="header d-flex align-items-center fixed-top">
        <!-- Header content -->
    </header>
        <section id="hero" class="hero section">
         <img src="assets/img/sch.jpg" alt="" data-aos="fade-in">
    <section id="events" class="section">
            <div class="container">
                <h2>Sports Events</h2>
                <table class="event-table" id="eventTable">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)">Sport</th>
                            <th onclick="sortTable(1)">Date</th>
                            <th>Time</th>
                            <th>Venue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display data in table format
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["sport"] . "</td>";
                                echo "<td>" . $row["date"] . "</td>";
                                echo "<td>" . $row["time"] . "</td>";
                                echo "<td>" . $row["venue"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No events found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
  </footer>
    <script>
        var sortDirection = [];

        function sortTable(columnIndex) {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("eventTable");
            switching = true;
            sortDirection[columnIndex] = !sortDirection[columnIndex];
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[columnIndex];
                    y = rows[i + 1].getElementsByTagName("td")[columnIndex];
                    if (sortDirection[columnIndex]) {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
            updateArrow(columnIndex);
        }

        function updateArrow(columnIndex) {
            var headers = document.querySelectorAll("#eventTable th");
            headers.forEach(function(header, index) {
                if (index !== columnIndex) {
                    header.classList.remove("asc", "desc");
                }
            });
            var sortedHeader = headers[columnIndex];
            sortedHeader.classList.toggle("asc", sortDirection[columnIndex]);
            sortedHeader.classList.toggle("desc", !sortDirection[columnIndex]);
        }
    </script>

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

</body>

</html><?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

