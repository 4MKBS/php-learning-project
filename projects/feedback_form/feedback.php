<?php
// DB connection info
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "feedbackv1.0";

// Get POST data
$name    = htmlspecialchars($_POST["name"]);
$email   = htmlspecialchars($_POST["email"]);
$message = htmlspecialchars($_POST["message"]);

// Save to database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO feedbacks (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);
$stmt->execute();
$stmt->close();
$conn->close();

// Send email notification
$to      = "04mkbs@gmail.com"; // Replace with your email address
$subject = "New Feedback from $name";
$body    = "Name: $name\nEmail: $email\nMessage:\n$message";
$headers = "From: no-reply@yourdomain.com";

// mail($to, $subject, $body, $headers);

// Thank You Message
echo "<h2>Thanks, $name! Your feedback has been submitted.</h2>";
echo "<a href='feedbackForm.html'>Back to Form</a>";
?>
