<?php
require 'config.php';

// Fetch all blog posts
$sql = "SELECT id, title, content, created_at FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>My Simple Blog</h1>
    <a href="new_post.php" class="new-post-btn">+ Add New Post</a>
    <div class="posts">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="post">
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                <p><?php echo htmlspecialchars(substr($row['content'], 0, 150)) . '...'; ?></p>
                <a href="view_post.php?id=<?php echo $row['id']; ?>" class="read-more">Read More</a>
                <span class="post-date"><?php echo date('F d, Y', strtotime($row['created_at'])); ?></span>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>