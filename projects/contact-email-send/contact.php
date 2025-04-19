<?php
require 'vendor/autoload.php'; // Include Composer's autoload file
$config = require 'config.php'; // Load configuration from config.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$messageStatus = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $messageStatus = "<div class='error'>All fields are required!</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $messageStatus = "<div class='error'>Invalid email address!</div>";
    } else {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // SMTP server configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Use Gmail's SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = $config['mail']; // Your Gmail address
            $mail->Password = $config['password']; // Your Gmail password or app-specific password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS
            $mail->Port = 587; // SMTP port for STARTTLS

            // Email settings
            $mail->setFrom($email, $name); // Sender's email and name
            $mail->addAddress($config['mail']); // Replace with the recipient's email address
            $mail->Subject = $subject;
            $mail->Body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

            // Send the email
            $mail->send();
            $messageStatus = "<div class='success'>Message sent successfully!</div>";
        } catch (Exception $e) {
            $messageStatus = "<div class='error'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Contact Us</h1>
    <?php echo $messageStatus; ?>
    <script>
        setTimeout(() => {
            const messageDiv = document.querySelector('.error, .success');
            if (messageDiv) {
                messageDiv.style.display = 'none';
            }
        }, 5000);
    </script>
    <form action="" method="POST">
        <div class="form-group">
            <input type="text" name="name" placeholder="Your Name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <input type="email" name="email" placeholder="Your Email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <input type="text" name="subject" placeholder="Subject" value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <textarea name="message" placeholder="Your Message" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
        </div>
        <button type="submit">Send Message</button>
    </form>
</div>
</body>
</html>