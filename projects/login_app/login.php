<?php
require 'config.php';
session_start();
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username == "" || $password == "") {
        $message = "All fields are required.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username=? OR email=?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $user, $hash);
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                $_SESSION["user_id"] = $id;
                $_SESSION["username"] = $user;
                header("Location: dashboard.php");
                exit;
            } else {
                $message = "Invalid credentials.";
            }
        } else {
            $message = "Invalid credentials.";
        }
        $stmt->close();
    }
}
$registered = isset($_GET['registered']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <form class="form" method="post" autocomplete="off">
        <h2>Login</h2>
        <?php if ($registered): ?>
            <div class="success">Registration successful! Please login.</div>
        <?php endif; ?>
        <?php if ($message): ?>
            <div class="error"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <div class="input-group">
            <input type="text" name="username" placeholder="Username or Email" value="<?php echo htmlspecialchars($_POST['username'] ?? ""); ?>" required>
        </div>
        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit">Login</button>
        <p class="switch-link">Don't have an account? <a href="register.php">Register here</a></p>
    </form>
</div>
</body>
</html>