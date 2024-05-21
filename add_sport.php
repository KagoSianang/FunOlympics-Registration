<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "funolympics";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sport = $_POST['sport'];
    $date = $_POST['date'];
    $image = $_FILES['image'];

    $target_dir = "uploads/";
    $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . basename($image["name"]);

    // Generate a unique file name if the file already exists
    if (file_exists($target_file)) {
        $unique_name = pathinfo($image["name"], PATHINFO_FILENAME) . '_' . time() . '.' . $imageFileType;
        $target_file = $target_dir . $unique_name;
    }

    $uploadOk = 1;

    // Check if image file is an actual image or fake image
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        $message = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($image["size"] > 500000) { // 500KB limit for example
        $message = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $message = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            $message = "The file " . htmlspecialchars(basename($image["name"])) . " has been uploaded.";

            $stmt = $conn->prepare("INSERT INTO sports (name, date, image) VALUES (?, ?, ?)");
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("sss", $sport, $date, $target_file);
            if ($stmt->execute() === false) {
                $message = "Execute failed: " . $stmt->error;
            } else {
                $message = "New sport added successfully.";
            }

            $stmt->close();
        } else {
            $message = "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Sport</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link href="Images/logo.png" rel="icon">
    <script>
        function showMessage(message) {
            if (message !== "") {
                alert(message);
            }
        }
    </script>
</head>
<body onload="showMessage('<?php echo $message; ?>')">
    <div class="container">
        <h1>Add New Sport</h1>
        <form method="POST" action="add_sport.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="sport">Sport Name</label>
                <input type="text" class="form-control" id="sport" name="sport" required>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="text" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="image">Sport Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Sport</button>
        </form>
    </div>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
