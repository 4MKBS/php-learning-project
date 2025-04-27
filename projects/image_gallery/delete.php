<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageDir = "uploads/";
    $imageToDelete = $_POST['image'];

    // Ensure the file exists before deleting
    if (file_exists($imageDir . $imageToDelete)) {
        unlink($imageDir . $imageToDelete);
    }

    header("Location: index.php");
    exit();
}
?>