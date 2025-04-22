<?php
// Function to get the user's IP address
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // IP from shared internet
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // IP passed from proxy
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // Default fallback
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Retrieve the user's IP address
$userIP = getUserIP();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Address Finder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>IP Address Finder</h1>
    <p>Your IP Address is:</p>
    <div class="ip-box">
        <?php echo htmlspecialchars($userIP); ?>
    </div>
</div>
</body>
</html>