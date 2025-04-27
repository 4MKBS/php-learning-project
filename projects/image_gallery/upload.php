<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = "uploads/";
    $file = $_FILES['image'];

    // Validate the file
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file['name']);
        $fileTmpPath = $file['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = uniqid() . "." . $fileExtension;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destination)) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error: Failed to move the uploaded file.";
            }
        } else {
            echo "Error: Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        echo "Error: File upload error.";
    }
}
?>