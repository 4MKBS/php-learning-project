<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = "uploads/";
    $fileToDelete = $_POST['file'];

    // Ensure the file exists before deleting
    if (file_exists($uploadDir . $fileToDelete)) {
        unlink($uploadDir . $fileToDelete);
    }

    header("Location: index.php");
    exit();
}
?>