<?php
$bmiResult = "";
$category = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $weight = $_POST['weight'] ?? null;
    $height = $_POST['height'] ?? null;

    // Validate inputs
    if (is_numeric($weight) && is_numeric($height) && $weight > 0 && $height > 0) {
        // Calculate BMI
        $bmi = $weight / ($height * $height);
        $bmiResult = number_format($bmi, 2);

        // Determine BMI category
        if ($bmi < 18.5) {
            $category = "Underweight";
        } elseif ($bmi >= 18.5 && $bmi < 24.9) {
            $category = "Normal weight";
        } elseif ($bmi >= 25 && $bmi < 29.9) {
            $category = "Overweight";
        } else {
            $category = "Obese";
        }
    } else {
        $bmiResult = "Invalid input. Please enter valid numbers for weight and height.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>BMI Calculator</h1>
    <form method="POST" class="bmi-form">
        <div class="form-group">
            <label for="weight">Weight (kg):</label>
            <input type="number" step="0.1" name="weight" id="weight" placeholder="Enter your weight" required>
        </div>
        <div class="form-group">
            <label for="height">Height (m):</label>
            <input type="number" step="0.01" name="height" id="height" placeholder="Enter your height" required>
        </div>
        <button type="submit">Calculate BMI</button>
    </form>
    <?php if ($bmiResult): ?>
        <div class="result">
            <p>Your BMI: <strong><?php echo htmlspecialchars($bmiResult); ?></strong></p>
            <?php if ($category): ?>
                <p>Category: <strong><?php echo htmlspecialchars($category); ?></strong></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>