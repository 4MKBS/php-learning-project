<?php
require 'config.php';

$id = intval($_GET['id']);
$sql = "SELECT title, content, created_at FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <a href="index.php" class="back-btn">← Back to Home</a>
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <span class="post-date"><?php echo date('F d, Y', strtotime($post['created_at'])); ?></span>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
</div>
</body>
</html>