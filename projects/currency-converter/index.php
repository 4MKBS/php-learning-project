<?php
$amount = "";
$from = "USD";
$to = "EUR";
$result = "";
$error = "";

$currencies = ["USD", "EUR", "GBP", "INR", "AUD", "CAD", "CHF", "CNY", "JPY"];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amount = $_POST['amount'] ?? "";
    $from = $_POST['from'] ?? "USD";
    $to = $_POST['to'] ?? "EUR";
    if (!is_numeric($amount) || $amount < 0) {
        $error = "Please enter a valid amount.";
    } elseif ($from === $to) {
        $result = number_format($amount, 2) . " " . htmlspecialchars($to);
    } else {
        // Fetch live rate from Frankfurter API
        $url = "https://api.frankfurter.app/latest?amount=$amount&from=$from&to=$to";
        $response = @file_get_contents($url);
        if ($response === FALSE) {
            $error = "Could not fetch rates. Try again.";
        } else {
            $data = json_decode($response, true);
            if (isset($data["rates"][$to])) {
                $converted = $data["rates"][$to];
                $result = number_format($converted, 2) . " " . htmlspecialchars($to);
            } else {
                $error = "Conversion rate not available.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Currency Converter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>💱 Live Currency Converter</h2>
    <form method="post" class="converter-form">
        <div class="input-group">
            <input type="text" name="amount" value="<?php echo htmlspecialchars($amount); ?>" placeholder="Amount" required>
            <select name="from">
                <?php foreach ($currencies as $cur): ?>
                    <option value="<?php echo $cur; ?>" <?php if($from === $cur) echo "selected"; ?>><?php echo $cur; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="to-text">to</span>
            <select name="to">
                <?php foreach ($currencies as $cur): ?>
                    <option value="<?php echo $cur; ?>" <?php if($to === $cur) echo "selected"; ?>><?php echo $cur; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Convert</button>
    </form>
    <?php if($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php elseif($result): ?>
        <div class="result"><?php echo "{$amount} {$from} = {$result}"; ?></div>
    <?php endif; ?>
    <div class="note">
        <small>Rates powered by <a href="https://www.frankfurter.app/" target="_blank">Frankfurter API</a></small>
    </div>
</div>
</body>
</html>