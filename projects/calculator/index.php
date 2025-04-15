<?php
// Initialize variables
$displayValue = '';
$calculation = ''; // Hidden field to store the full calculation string

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the hidden calculation string and the button pressed
    $calculation = $_POST['calculation'] ?? '';
    $buttonPressed = $_POST['button'] ?? '';
    $currentDisplay = $_POST['display'] ?? ''; // Get what was *visibly* displayed

    if ($buttonPressed == 'C') {
        // Clear button
        $displayValue = '';
        $calculation = '';
    } elseif ($buttonPressed == '=') {
        // Equals button - Try to evaluate the calculation string
        if (!empty($calculation)) {
            // SECURITY WARNING: eval() is dangerous with untrusted input.
            // Use only because we control the input via buttons.
            // Replace with a safer parser in production.
            try {
                // Basic sanitization: remove anything not a digit, operator, or dot.
                $safeCalculation = preg_replace('/[^0-9\+\-\*\/\.]/', '', $calculation);
                if ($safeCalculation === '') {
                    $displayValue = 'Error';
                } else {
                    // Use @ to suppress potential warnings/errors from eval, handle via catch
                    $result = @eval('return ' . $safeCalculation . ';');
                    if ($result === false || is_infinite($result) || is_nan($result)) {
                        $displayValue = 'Error';
                    } else {
                        $displayValue = $result;
                    }
                }
            } catch (ParseError | DivisionByZeroError $e) {
                $displayValue = 'Error';
            } catch (Throwable $e) { // Catch any other potential errors
                 $displayValue = 'Error';
            }
        }
        // Reset calculation string after evaluation (or error)
        $calculation = (string)$displayValue; // Start next calculation with the result
         if ($displayValue === 'Error') {
            $calculation = ''; // Clear calculation if error
         }

    } else {
        // Number or operator button
        // Append the button pressed to the hidden calculation string
        $calculation .= $buttonPressed;
        // Update the display value directly from the calculation string
        $displayValue = $calculation;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Calculator</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="calculator">
    <form method="post" action="">
        <input type="text" name="display" class="display" value="<?php echo htmlspecialchars($displayValue); ?>" readonly>
        <!-- Hidden field to keep track of the full calculation string -->
        <input type="hidden" name="calculation" value="<?php echo htmlspecialchars($calculation); ?>">

        <table>
            <tr>
                <td><input type="submit" name="button" value="7"></td>
                <td><input type="submit" name="button" value="8"></td>
                <td><input type="submit" name="button" value="9"></td>
                <td><input type="submit" name="button" value="/" class="operator"></td>
            </tr>
            <tr>
                <td><input type="submit" name="button" value="4"></td>
                <td><input type="submit" name="button" value="5"></td>
                <td><input type="submit" name="button" value="6"></td>
                <td><input type="submit" name="button" value="*" class="operator"></td>
            </tr>
            <tr>
                <td><input type="submit" name="button" value="1"></td>
                <td><input type="submit" name="button" value="2"></td>
                <td><input type="submit" name="button" value="3"></td>
                <td><input type="submit" name="button" value="-" class="operator"></td>
            </tr>
            <tr>
                <td><input type="submit" name="button" value="0"></td>
                <td><input type="submit" name="button" value="."></td>
                <td><input type="submit" name="button" value="C" class="clear"></td>
                <td><input type="submit" name="button" value="+" class="operator"></td>
            </tr>
            <tr>
                <td colspan="4"><input type="submit" name="button" value="=" class="equals"></td>
            </tr>
        </table>
    </form>
</div>

</body>
</html>