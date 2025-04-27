<?php
// Directory where images are stored
$imageDir = "uploads/";

// Fetch all images from the directory
$images = array_diff(scandir($imageDir), array('.', '..'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Image Gallery</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data" class="upload-form">
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>
    <div class="gallery">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $image): ?>
                <div class="image-card">
                    <img src="<?php echo $imageDir . $image; ?>" alt="Gallery Image">
                    <!-- download button -->
                    <a href="<?php echo $imageDir . $image; ?>" download class="download-btn">📩</a>
                    <form action="delete.php" method="POST">
                        <input type="hidden" name="image" value="<?php echo $image; ?>">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No images uploaded yet.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>