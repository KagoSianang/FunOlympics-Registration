<?php
// Include PHPMailer classes
require 'C:\xampp\htdocs\FunOlympics\Append\vendor\phpmailer\Exception.php';
require 'C:\xampp\htdocs\FunOlympics\Append\vendor\phpmailer\PHPMailer.php';
require 'C:\xampp\htdocs\FunOlympics\Append\vendor\phpmailer\SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "funolympics";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST["email"]);
    $token = bin2hex(random_bytes(50)); // Generate a unique token
    $expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token expires in 1 hour

    // Check if email exists in the users table
    $check_email_sql = "SELECT * FROM users WHERE email = '$email'";
    $check_email_result = $conn->query($check_email_sql);

    if ($check_email_result->num_rows > 0) {
        // Insert reset token into password_resets table
        $sql = "INSERT INTO password_resets (email, token, expiry) VALUES ('$email', '$token', '$expiry')";
        if ($conn->query($sql) === TRUE) {
            // Send reset email using PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'sianangkago@gmail.com';                 // SMTP username
                $mail->Password   = 'lmat kqhy gqnj iunk';                  // SMTP password (use App Password if 2FA is enabled)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to

                // Recipients
                $mail->setFrom('no-reply@yourdomain.com', 'Fun Olympics');
                $mail->addAddress($email);                                  // Add a recipient

                // Content
                $mail->isHTML(true);                                        // Set email format to HTML
                $mail->Subject = 'Password Reset Request';
                $resetLink = "http://localhost/FunOlympics/Append/reset_password_form.php?token=" . $token;
                $mail->Body    = "Click on the link below to reset your password:<br><br><a href=\"$resetLink\">$resetLink</a>";
                $mail->AltBody = "Click on the link below to reset your password:\n\n" . $resetLink;

                $mail->send();
                echo 'A password reset link has been sent to ' . $email;
            } catch (Exception $e) {
                echo "Failed to send email. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Failed to store reset token.";
        }
    } else {
        echo "No account found with that email.";
    }
}

// Close connection
$conn->close();
?>
