<?php
// Include the database connection
require 'config.php';

// Get the short code from the URL
$shortCode = trim($_GET['code']);

// Check if the short code exists in the database
$stmt = $conn->prepare("SELECT long_url FROM urls WHERE short_code = ?");
$stmt->bind_param("s", $shortCode);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $longUrl = $row['long_url'];

    // Redirect to the original URL
    header("Location: $longUrl");
    exit();
} else {
    // Display error message for invalid short code
    http_response_code(404);
    echo "Invalid short URL.";
}
?>