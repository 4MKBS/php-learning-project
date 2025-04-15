<?php
function convertTemperature($value, $from, $to) {
    if ($from == $to) return $value;
    // Convert input to Celsius
    switch ($from) {
        case "Celsius":
            $celsius = $value;
            break;
        case "Fahrenheit":
            $celsius = ($value - 32) * 5 / 9;
            break;
        case "Kelvin":
            $celsius = $value - 273.15;
            break;
        default:
            return null;
    }
    // Convert from Celsius to target
    switch ($to) {
        case "Celsius":
            return $celsius;
        case "Fahrenheit":
            return $celsius * 9 / 5 + 32;
        case "Kelvin":
            return $celsius + 273.15;
        default:
            return null;
    }
}
$result = "";
$input = "";
$from = "Celsius";
$to = "Fahrenheit";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = $_POST['input'] ?? "";
    $from = $_POST['from'] ?? "Celsius";
    $to = $_POST['to'] ?? "Fahrenheit";
    if (is_numeric($input)) {
        $converted = convertTemperature(floatval($input), $from, $to);
        $result = round($converted, 2) . " &deg;$to";
    } else {
        $result = "Please enter a valid number.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Temperature Converter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>🌡️ Temperature Converter</h2>
    <form method="post" class="converter-form">
        <div class="input-group">
            <input type="text" name="input" value="<?php echo htmlspecialchars($input); ?>" placeholder="Enter value" required>
            <select name="from">
                <option <?php if($from=="Celsius") echo "selected";?>>Celsius</option>
                <option <?php if($from=="Fahrenheit") echo "selected";?>>Fahrenheit</option>
                <option <?php if($from=="Kelvin") echo "selected";?>>Kelvin</option>
            </select>
            <span class="to-text">to</span>
            <select name="to">
                <option <?php if($to=="Celsius") echo "selected";?>>Celsius</option>
                <option <?php if($to=="Fahrenheit") echo "selected";?>>Fahrenheit</option>
                <option <?php if($to=="Kelvin") echo "selected";?>>Kelvin</option>
            </select>
        </div>
        <button type="submit">Convert</button>
    </form>
    <?php if($result): ?>
        <div class="result"><?php echo $result; ?></div>
    <?php endif; ?>
</div>
</body>
</html>