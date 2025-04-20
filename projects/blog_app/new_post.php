<?php
require 'config.php';

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars(trim($_POST['title']));
    $content = htmlspecialchars(trim($_POST['content']));

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $message = "Failed to add post.";
        }
    } else {
        $message = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Create a New Post</h1>
    <?php if ($message): ?>
        <div class="error"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <input type="text" name="title" placeholder="Enter Post Title" required>
        </div>
        <div class="form-group">
            <textarea name="content" placeholder="Enter Post Content" required></textarea>
        </div>
        <button type="submit">Publish</button>
    </form>
</div>
</body>
</html>