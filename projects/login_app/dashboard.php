<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <div class="dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <p>You are now logged in.</p>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>
</body>
</html>