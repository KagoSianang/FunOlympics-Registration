<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.html");
    exit();
}

// Database connection details
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

// Fetch users for the dropdown
$sql = "SELECT id, Name FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
} else {
    die("No users found.");
}

// Fetch sports for the dropdown
$sports_sql = "SELECT id, name FROM sports";
$sports_result = $conn->query($sports_sql);

if ($sports_result->num_rows > 0) {
    $sports = $sports_result->fetch_all(MYSQLI_ASSOC);
} else {
    die("No sports found.");
}

// Fetch events for the list
$events_sql = "SELECT * FROM schedule";
$events_result = $conn->query($events_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link href="Images/logo.png" rel="icon">
    <style>
        body {
            display: flex;
            background-color: #f8f9fa;
        }
        .navmenu {
            width: 250px;
            background-color: #343a40;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #fff;
        }
        .navmenu a {
            color: #fff;
            padding: 15px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }
        .navmenu a:hover {
            background-color: #495057;
        }
        .container {
            margin-left: 270px;
            padding: 20px;
            width: calc(100% - 270px);
        }
        .section {
            margin-top: 20px;
            border: 1px solid #dee2e6;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
        }
        .navmenu .bottom-section {
            padding: 15px;
            text-align: center;
        }
        .navmenu .bottom-section img {
            width: 100px;
        }
        h1, h2 {
            color: #343a40;
        }
        .chat-box {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: white;
        }
        .chat-message {
            margin-bottom: 10px;
            color: black;
        }
        .timestamp {
            color: gray;
            font-size: 12px;
            margin-bottom: 5px;
        }
        .chat-message.admin {
            text-align: right;
            background-color: #f2f2f2;
            border-radius: 15px;
            padding: 10px 15px;
            background-color: greenyellow;
        }
        .chat-message.user {
            text-align: left;
            background-color: white;
            border-radius: 15px;
            padding: 5px 15px;
            background-color: skyblue;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<body>
    <div class="navmenu">
        <div>
            <a href="#favorites"><i class="bi bi-star-fill"></i> Most Marked Favorite Sports</a>
            <a href="#change-password"><i class="bi bi-key-fill"></i> Change User Password</a>
            <a href="#change-details"><i class="bi bi-person-fill"></i> Change User Details</a>
            <a href="#capture-event"><i class="bi bi-calendar-event-fill"></i> Capture New Event</a>
            <a href="#edit-event"><i class="bi bi-pencil-fill"></i> Edit Events</a>
            <a href="#add-sport"><i class="bi bi-plus-square-fill"></i> Add New Sport</a>
            <a href="#add-youtube-link"><i class="bi bi-youtube"></i> Add YouTube Link to Sport</a>
            <a href="#chatbox"><i class="bi bi-chat-fill"></i> Admin Chat</a>
        </div>
        <div class="bottom-section">
            <a href="logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
            <br><br>
            <img src="Images/logo.png" alt="Logo">
        </div>
    </div>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-6">
                <section id="favorites" class="section">
                    <h2>Most Marked Favorite Sports</h2>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Sport</th>
                                <th>Favorite Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sport_favorites_sql = "SELECT sport_name, COUNT(*) as favorite_count FROM user_favorites GROUP BY sport_name ORDER BY favorite_count DESC";
                            $sport_favorites_result = $conn->query($sport_favorites_sql);

                            if ($sport_favorites_result->num_rows > 0) {
                                while ($row = $sport_favorites_result->fetch_assoc()) {
                                    echo "<tr><td>{$row['sport_name']}</td><td>{$row['favorite_count']}</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>No data available</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </section>
            </div>
            <div class="col-md-6">
                <section id="change-password" class="section">
                    <h2>Change User Password</h2>
                    <form method="POST" action="change_password.php">
                        <div class="form-group">
                            <label for="user_id">Select User:</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">--Select User--</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?php echo htmlspecialchars($user['id']); ?>"><?php echo htmlspecialchars($user['Name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <section id="change-details" class="section">
                    <h2>Change User Details</h2>
                    <form method="POST" action="change_details.php">
                        <div class="form-group">
                            <label for="user_id">User ID</label>
                            <input type="number" class="form-control" id="user_id" name="user_id" required>
                        </div>
                        <div class="form-group">
                            <label for="new_username">New Username</label>
                            <input type="text" class="form-control" id="new_username" name="new_username" required>
                        </div>
                        <div class="form-group">
                            <label for="new_email">New Email</label>
                            <input type="email" class="form-control" id="new_email" name="new_email" required>
                        </div>
                        <div class="form-group">
                            <label for="new_country">New Country</label>
                            <input type="text" class="form-control" id="new_country" name="new_country" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Change Details</button>
                    </form>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <section id="capture-event" class="section">
                    <h2>Capture New Event</h2>
                    <form method="POST" action="capture_event.php">
                        <div class="form-group">
                            <label for="sport">Sport</label>
                            <select name="sport" id="sport" class="form-control" required>
                                <option value="">--Select Sport--</option>
                                <?php foreach ($sports as $sport): ?>
                                    <option value="<?php echo htmlspecialchars($sport['name']); ?>"><?php echo htmlspecialchars($sport['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="time">Time</label>
                            <input type="time" class="form-control" id="time" name="time" required>
                        </div>
                        <div class="form-group">
                            <label for="venue">Venue</label>
                            <input type="text" class="form-control" id="venue" name="venue" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Capture Event</button>
                    </form>
                </section>
            </div>
            <div class="col-md-6">
                <section id="edit-event" class="section">
                    <h2>Edit Events</h2>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Sport</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Venue</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($events_result->num_rows > 0) {
                                while ($row = $events_result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$row['Sport']}</td>
                                        <td>{$row['Date']}</td>
                                        <td>{$row['Time']}</td>
                                        <td>{$row['Venue']}</td>
                                        <td><button class='btn btn-warning' onclick='editEvent({$row['id']})'>Edit</button></td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No events available</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </section>
                <!-- Edit Event Modal -->
                <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="edit-event-form" method="POST" action="edit_event.php">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="edit_event_id" name="id">
                                    <div class="form-group">
                                        <label for="edit_sport">Sport</label>
                                        <input type="text" class="form-control" id="edit_sport" name="sport" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_date">Date</label>
                                        <input type="date" class="form-control" id="edit_date" name="date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_time">Time</label>
                                        <input type="time" class="form-control" id="edit_time" name="time" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_venue">Venue</label>
                                        <input type="text" class="form-control" id="edit_venue" name="venue" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                function editEvent(id) {
                    $.ajax({
                        url: 'get_event.php',
                        method: 'GET',
                        data: { id: id },
                        success: function(response) {
                            var event = JSON.parse(response);
                            $('#edit_event_id').val(event.id);
                            $('#edit_sport').val(event.sport);
                            $('#edit_date').val(event.date);
                            $('#edit_time').val(event.time);
                            $('#edit_venue').val(event.venue);
                            $('#editEventModal').modal('show');
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: " + status + error);
                        }
                    });
                }
                </script>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <section id="add-sport" class="section">
                    <h2>Add New Sport</h2>
                    <form method="POST" action="add_sport.php">
                        <div class="form-group">
                            <label for="sport_name">Sport Name</label>
                            <input type="text" class="form-control" id="sport_name" name="sport_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Sport</button>
                    </form>
                </section>
            </div>
            <div class="col-md-6">
                <section id="add-youtube-link" class="section">
                    <h2>Add YouTube Link to Sport</h2>
                    <form method="POST" action="add_youtube_link.php">
                        <div class="form-group">
                            <label for="sport">Sport</label>
                            <select name="sport" id="sport" class="form-control" required>
                                <option value="">--Select Sport--</option>
                                <?php foreach ($sports as $sport): ?>
                                    <option value="<?php echo htmlspecialchars($sport['name']); ?>"><?php echo htmlspecialchars($sport['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="youtube_link">YouTube Link</label>
                            <input type="url" class="form-control" id="youtube_link" name="youtube_link" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add YouTube Link</button>
                    </form>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <section id="chatbox" class="section">
                    <h2>Admin Chat</h2>
                    <div class="chat-box">
                        <div id="chat-messages"></div>
                    </div>
                    <form id="chat-form" method="POST" action="send_message.php">
                        <div class="form-group">
                            <label for="chat-message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
