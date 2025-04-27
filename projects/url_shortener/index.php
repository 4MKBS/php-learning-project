<?php
require 'config.php';

$shortUrl = "";
$error = "";

function generateShortCode($length = 6) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $longUrl = trim($_POST['long_url']);
    
    // Validate URL
    if (!filter_var($longUrl, FILTER_VALIDATE_URL)) {
        $error = "Invalid URL. Please enter a valid URL.";
    } else {
        // Check if the URL already exists in the database
        $stmt = $conn->prepare("SELECT short_code FROM urls WHERE long_url = ?");
        $stmt->bind_param("s", $longUrl);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $shortUrl = "http://localhost/php-learning-project/projects/url_shortener/" . $row['short_code'];
        } else {
            // Generate a unique short code
            $shortCode = generateShortCode();
            $stmt = $conn->prepare("INSERT INTO urls (short_code, long_url) VALUES (?, ?)");
            $stmt->bind_param("ss", $shortCode, $longUrl);
            
            if ($stmt->execute()) {
                $shortUrl = "http://localhost/php-learning-project/projects/url_shortener/" . $shortCode;
            } else {
                $error = "Failed to shorten the URL. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>URL Shortener</h1>
    <form method="POST">
        <input type="url" name="long_url" placeholder="Enter your long URL" required>
        <button type="submit">Shorten</button>
    </form>
    <?php if ($shortUrl): ?>
        <div class="result">
            Short URL: <a href="<?php echo $shortUrl; ?>" target="_blank"><?php echo $shortUrl; ?></a>
        </div>
    <?php elseif ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
</div>
</body>
</html>