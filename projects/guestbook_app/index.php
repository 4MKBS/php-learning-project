<?php
require 'config.php';

$messageStatus = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate inputs
    if (!empty($name) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO messages (name, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $message);
        if ($stmt->execute()) {
            $messageStatus = "<div class='success'>Message added successfully!</div>";
        } else {
            $messageStatus = "<div class='error'>Failed to add message. Please try again.</div>";
        }
        $stmt->close();
    } else {
        $messageStatus = "<div class='error'>Both fields are required!</div>";
    }
}

// Fetch all messages
$result = $conn->query("SELECT name, message, created_at FROM messages ORDER BY created_at DESC");
$messages = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestbook</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Guestbook</h1>
    <?php echo $messageStatus; ?>
    <form method="POST" class="guestbook-form">
        <div class="form-group">
            <input type="text" name="name" placeholder="Your Name" required>
        </div>
        <div class="form-group">
            <textarea name="message" placeholder="Your Message" required></textarea>
        </div>
        <button type="submit">Submit</button>
    </form>
    <div class="messages">
        <?php foreach ($messages as $msg): ?>
            <div class="message">
                <h3><?php echo htmlspecialchars($msg['name']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                <span class="date"><?php echo date('F d, Y h:i A', strtotime($msg['created_at'])); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>