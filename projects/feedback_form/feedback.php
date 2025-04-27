<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST["name"]);
    $email   = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    $entry = "Name: $name\nEmail: $email\nMessage: $message\n---\n";

    // Save feedback to a file
    file_put_contents("feedbacks.txt", $entry, FILE_APPEND);

    echo "<h2>Thank you for your feedback, $name!</h2>";
    echo "<a href='feedbackForm.html'>Go back</a>";
} else {
    echo "Invalid request.";
}
?>
