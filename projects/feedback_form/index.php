<?php
// Include database configuration
require 'config.php';

$name = $email = $message = "";
$nameErr = $emailErr = $messageErr = $successMsg = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    // Validate message
    if (empty($_POST["message"])) {
        $messageErr = "Feedback message is required";
    } else {
        $message = htmlspecialchars($_POST["message"]);
    }

    // If no errors, insert into database
    if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
        $stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            // Redirect to the same page with a success message
            header("Location: " . $_SERVER["PHP_SELF"] . "?success=true");
            exit(); // Prevent further execution
        } else {
            $successMsg = "Error: Could not save feedback. Please try again.";
        }

        $stmt->close();
    }
}

// Show success message if redirected
if (isset($_GET['success']) && $_GET['success'] === "true") {
    $successMsg = "Thank you for your feedback!";
    // 2 seconds delay before redirecting to the form
    echo "<script>
            setTimeout(() => {
                window.location.href = '" . $_SERVER["PHP_SELF"] . "';
            }, 2000);
          </script>";
                
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Feedback Form</h1>
        <p>Please fill out the form below to share your feedback.</p>
        <?php if ($successMsg): ?>
            <div class="success-message"><?php echo $successMsg; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="<?php echo $name; ?>">
                <span class="error"><?php echo $nameErr; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo $emailErr; ?></span>
            </div>
            <div class="form-group">
                <label for="message">Feedback</label>
                <textarea name="message" id="message" rows="5"><?php echo $message; ?></textarea>
                <span class="error"><?php echo $messageErr; ?></span>
            </div>
            <button type="submit">Submit Feedback</button>
        </form>
    </div>
</body>

</html>