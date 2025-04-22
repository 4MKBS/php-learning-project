<?php
$ageResult = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dob = $_POST['dob'] ?? '';

    // Validate the DOB input
    if (!empty($dob) && strtotime($dob) < time()) {
        $dobDate = new DateTime($dob);
        $currentDate = new DateTime();
        $ageInterval = $currentDate->diff($dobDate);

        $years = $ageInterval->y;
        $months = $ageInterval->m;
        $days = $ageInterval->d;

        $ageResult = "You are <strong>$years years, $months months, and $days days</strong> old.";
    } else {
        $ageResult = "<div class='error'>Please enter a valid date of birth.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Age Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Age Calculator</h1>
    <form method="POST">
        <div class="form-group">
            <label for="dob">Enter Your Date of Birth:</label>
            <input type="date" name="dob" id="dob" required>
        </div>
        <button type="submit">Calculate Age</button>
    </form>
    <?php if ($ageResult): ?>
        <div class="result">
            <?php echo $ageResult; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>