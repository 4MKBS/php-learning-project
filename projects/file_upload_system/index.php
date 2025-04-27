<?php
// Directory where files are stored
$uploadDir = "uploads/";

// Fetch all files from the directory
$files = array_diff(scandir($uploadDir), array('.', '..'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>File Upload System</h1>
    <div class="upload-area" id="uploadArea">
        <p>Drag & Drop files here or <span class="browse-btn">Browse</span></p>
        <input type="file" id="fileInput" multiple hidden>
    </div>
    <div id="progressContainer" class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>
    <div class="file-list">
        <h2>Uploaded Files</h2>
        <ul>
            <?php if (!empty($files)): ?>
                <?php foreach ($files as $file): ?>
                    <li>
                        <a href="<?php echo $uploadDir . $file; ?>" target="_blank"><?php echo $file; ?></a>
                        <form action="delete.php" method="POST" class="delete-form">
                            <input type="hidden" name="file" value="<?php echo $file; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No files uploaded yet.</p>
            <?php endif; ?>
        </ul>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>