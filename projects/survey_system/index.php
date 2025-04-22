<?php
require 'config.php';

$message = "";

// Handle survey submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $question1 = $_POST['question1'] ?? null;
    $question2 = $_POST['question2'] ?? null;
    $question3 = htmlspecialchars(trim($_POST['question3'] ?? ""));

    // Validate inputs
    if ($question1 && $question2 && !empty($question3)) {
        $stmt = $conn->prepare("INSERT INTO responses (question1, question2, question3) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $question1, $question2, $question3);
        if ($stmt->execute()) {
            $message = "<div class='success'>Thank you for your response!</div>";
        } else {
            $message = "<div class='error'>Failed to submit your response. Please try again.</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='error'>All fields are required!</div>";
    }
}

// Fetch survey results
$totalResponses = $conn->query("SELECT COUNT(*) AS total FROM responses")->fetch_assoc()['total'];
$yesQuestion1 = $conn->query("SELECT COUNT(*) AS yes FROM responses WHERE question1 = 'Yes'")->fetch_assoc()['yes'];
$yesQuestion2 = $conn->query("SELECT COUNT(*) AS yes FROM responses WHERE question2 = 'Yes'")->fetch_assoc()['yes'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Survey System</h1>
    <?php echo $message; ?>
    <form method="POST" class="survey-form">
        <div class="form-group">
            <label>Do you like our website?</label>
            <label><input type="radio" name="question1" value="Yes" required> Yes</label>
            <label><input type="radio" name="question1" value="No"> No</label>
        </div>
        <div class="form-group">
            <label>Would you recommend us to others?</label>
            <label><input type="radio" name="question2" value="Yes" required> Yes</label>
            <label><input type="radio" name="question2" value="No"> No</label>
        </div>
        <div class="form-group">
            <label>Any additional feedback?</label>
            <textarea name="question3" placeholder="Enter your feedback here..." required></textarea>
        </div>
        <button type="submit">Submit</button>
    </form>
    <div class="results">
        <h2>Survey Results</h2>
        <p>Total Responses: <strong><?php echo $totalResponses; ?></strong></p>
        <p>People who like our website: <strong><?php echo $yesQuestion1; ?></strong></p>
        <p>People who would recommend us: <strong><?php echo $yesQuestion2; ?></strong></p>
    </div>
</div>
</body>
</html>