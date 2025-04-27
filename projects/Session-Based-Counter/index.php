<?php
// Start the session
session_start();

// Initialize the counter if it doesn't exist
if (!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
}

// Check if the reset button was clicked
if (isset($_POST['reset'])) {
    $_SESSION['counter'] = 0;
} else {
    // Increment the counter on page load
    $_SESSION['counter']++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session-Based Counter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Session-Based Counter</h1>
    <p>This counter increments every time you refresh the page!</p>
    <div class="counter-display">
        <h2>Counter Value</h2>
        <div class="counter"><?php echo $_SESSION['counter']; ?></div>
    </div>
    <form method="POST">
        <button type="submit" name="reset" class="reset-btn">Reset Counter</button>
    </form>
</div>
</body>
</html>