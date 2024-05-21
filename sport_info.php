<?php
session_start();

// Fetch sport name from the URL
$sport_name = $_GET['sport'];

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "funolympics");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch sport information
$sql = "SELECT id, name, image, date FROM sports WHERE name = '$sport_name'";
$result = mysqli_query($conn, $sql);

// Check if there are any records
if (mysqli_num_rows($result) > 0) {
    // Fetch the first row
    $row = mysqli_fetch_assoc($result);
    // Store the values in variables
    $sport_id = $row['id'];
    $sport_name = $row['name'];
    $sport_image = $row['image'];
    $sport_date = $row['date'];
} else {
    // No records found
    $sport_id = 0;
    $sport_name = "Unknown";
    $sport_image = "default_image.jpg"; // Provide a default image
    $sport_date = "Unknown";
}

// Query to fetch YouTube links
$youtube_sql = "SELECT youtube_link FROM youtube_links WHERE sport_id = $sport_id";
$youtube_result = mysqli_query($conn, $youtube_sql);

// Query to fetch schedule information
$schedule_sql = "SELECT sport, date, time, venue FROM schedule WHERE sport = '$sport_name' ORDER BY date, time";
$schedule_result = mysqli_query($conn, $schedule_sql);

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($sport_name); ?> - Favports</title>
    <link href="Images/logo.png" rel="icon">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .header {
            background-color: black;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .header h1 {
            margin: 0;
        }

        .header p {
            margin: 5px 0 0 0;
        }

        .header .back-button {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #fff;
            color: #0033cc;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .container {
            display: grid;
            grid-template-columns: 2fr 3fr;
            gap: 20px;
            padding: 20px;
        }

        .sport-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .sport-info img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .sport-video {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .sport-video iframe {
            width: 100%;
            height: 200px;
            border-radius: 8px;
        }

        .schedule {
            margin-top: 20px;
        }

        .schedule table {
            width: 100%;
            border-collapse: collapse;
        }

        .schedule th, .schedule td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .schedule th {
            background-color: #0033cc;
            color: white;
        }
    </style>
</head>

<body>

    <header class="header">
        <a href="index.php" class="back-button">Back</a>
        <h1><?php echo htmlspecialchars($sport_name); ?></h1>
        <p>Date: <?php echo htmlspecialchars($sport_date); ?></p>
    </header>

    <div class="container">
        <div class="sport-info">
            <img src="<?php echo htmlspecialchars($sport_image); ?>" alt="<?php echo htmlspecialchars($sport_name); ?>">
            <!-- Additional sport information can be placed here -->
            <div class="schedule">
                <h2>Schedule</h2>
                <?php if (mysqli_num_rows($schedule_result) > 0) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Event Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Venue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($schedule_result)) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['sport']); ?></td>
                                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['time']); ?></td>
                                    <td><?php echo htmlspecialchars($row['venue']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No schedule available</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="sport-video">
            <?php if (mysqli_num_rows($youtube_result) > 0) : ?>
                <?php while ($row = mysqli_fetch_assoc($youtube_result)) : ?>
                    <?php
                    $youtube_link = $row['youtube_link'];
                    // Convert YouTube URL to embeddable format if necessary
                    if (strpos($youtube_link, 'watch?v=') !== false) {
                        $youtube_link = str_replace('watch?v=', 'embed/', $youtube_link);
                    }
                    ?>
                    <iframe src="<?php echo htmlspecialchars($youtube_link); ?>" frameborder="0" allowfullscreen></iframe>
                <?php endwhile; ?>
            <?php else : ?>
                <p>No video available</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
