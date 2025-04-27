<?php
session_start();

// Replace with your own credentials
$admin_user = "admin";
$admin_pass = "12345"; // ⚠️ Change this to something secure

if ($_POST['username'] === $admin_user && $_POST['password'] === $admin_pass) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: viewFeedbacks.php");
} else {
    echo "<h3>Invalid credentials. <a href='adminLogin.php'>Try again</a></h3>";
}
?>
