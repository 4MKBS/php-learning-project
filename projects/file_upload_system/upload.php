<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = "uploads/";
    $file = $_FILES['file'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file['name']);
        $fileTmpPath = $file['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'mkv','jpeg', 'png', 'gif', 'pdf', 'docx', 'xlsx', 'txt', 'zip', 'rar', 'mp4', 'mp3', 'avi', 'mov'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = uniqid() . "-" . $fileName;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destination)) {
                echo json_encode(['success' => true, 'fileName' => $newFileName]);
                exit();
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to move the uploaded file.']);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid file type.']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'File upload error.']);
        exit();
    }
}
?>