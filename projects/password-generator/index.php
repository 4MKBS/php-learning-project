<?php
function generatePassword($length = 12, $includeSymbols = true, $includeNumbers = true, $includeUppercase = true, $includeLowercase = true) {
    $symbols = '!@#$%^&*()-_=+<>?';
    $numbers = '0123456789';
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';

    $chars = '';
    if ($includeSymbols) $chars .= $symbols;
    if ($includeNumbers) $chars .= $numbers;
    if ($includeUppercase) $chars .= $uppercase;
    if ($includeLowercase) $chars .= $lowercase;

    if ($chars === '') return '';

    $password = '';
    $maxIndex = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $maxIndex)];
    }
    return $password;
}

// Handle form and generate 4 passwords
$passwords = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $len = isset($_POST["length"]) ? intval($_POST["length"]) : 12;
    $symbols = isset($_POST["symbols"]);
    $numbers = isset($_POST["numbers"]);
    $uppercase = isset($_POST["uppercase"]);
    $lowercase = isset($_POST["lowercase"]);
    for ($i = 0; $i < 4; $i++) {
        $passwords[] = generatePassword($len, $symbols, $numbers, $uppercase, $lowercase);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Password Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            background: linear-gradient(135deg, #f8fafc, #e0e7ef 90%);
            min-height: 100vh; margin: 0; 
            display: flex; justify-content: center; align-items: center;
        }
        .pwgen-container {
            background: #fff;
            padding: 2rem 2.5rem 2.5rem 2.5rem;
            border-radius: 16px;
            box-shadow: 0 2px 24px #cbd5e1cc;
            text-align: center;
            min-width: 320px;
            max-width: 95vw;
        }
        h2 {
            color: #2563eb;
            margin-bottom: 8px;
        }
        form {
            margin-bottom: 20px;
        }
        .pw-row {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        .pw-box {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 16px 13px;
            min-width: 170px;
            text-align: center;
            font-size: 1.08rem;
            font-family: 'Consolas', 'Menlo', monospace;
            cursor: pointer;
            box-shadow: 0 2px 8px #e2e8f0;
            position: relative;
            transition: background 0.15s, box-shadow 0.15s;
            color: #111827;
        }
        .pw-box:hover {
            background: #dbeafe;
            box-shadow: 0 4px 16px #e0e7ef;
        }
        .copied {
            position: absolute;
            top: 8px;
            right: 10px;
            font-size: 0.85rem;
            color: #16a34a;
            background: #ecfdf5;
            padding: 2px 8px;
            border-radius: 4px;
            opacity: 0.9;
        }
        .options {
            margin: 12px 0;
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }
        label {
            margin-right: 0px;
            font-size: 1rem;
            color: #374151;
        }
        input[type="number"] {
            width: 54px;
            padding: 4px;
            border-radius: 5px;
            border: 1px solid #cbd5e1;
            font-size: 1rem;
        }
        button[type="submit"] {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 9px 22px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.08rem;
            margin-top: 10px;
            font-weight: 500;
            box-shadow: 0 1px 6px #e0e7ef;
            transition: background 0.15s;
        }
        button[type="submit"]:hover {
            background: #1d4ed8;
        }
        @media (max-width: 480px) {
            .pw-row { flex-direction: column; gap: 10px; }
            .pwgen-container { padding: 1.3rem 0.4rem 1.8rem 0.4rem; min-width: 0; }
        }
    </style>
</head>
<body>
    <div class="pwgen-container">
        <h2>Password Generator</h2>
        <form method="post" autocomplete="off">
            <label>Password Length:
                <input type="number" name="length" min="6" max="64" value="<?php echo isset($_POST['length']) ? intval($_POST['length']) : 12; ?>">
            </label>
            <div class="options">
                <label><input type="checkbox" name="symbols" <?php if (!isset($_POST["symbols"]) || $_POST["symbols"]) echo "checked"; ?>> Symbols</label>
                <label><input type="checkbox" name="numbers" <?php if (!isset($_POST["numbers"]) || $_POST["numbers"]) echo "checked"; ?>> Numbers</label>
                <label><input type="checkbox" name="uppercase" <?php if (!isset($_POST["uppercase"]) || $_POST["uppercase"]) echo "checked"; ?>> Uppercase</label>
                <label><input type="checkbox" name="lowercase" <?php if (!isset($_POST["lowercase"]) || $_POST["lowercase"]) echo "checked"; ?>> Lowercase</label>
            </div>
            <button type="submit">Generate</button>
        </form>
        <?php if ($passwords): ?>
            <div class="pw-row">
                <?php foreach ($passwords as $i => $pw): ?>
                    <div class="pw-box" tabindex="0" onclick="copyPassword(this, '<?php echo htmlspecialchars($pw, ENT_QUOTES); ?>')">
                        <span class="pw-text"><?php echo htmlspecialchars($pw); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div style="font-size:0.97rem;color:#64748b;">Click on a password to copy</div>
        <?php endif; ?>
    </div>
    <script>
    function copyPassword(el, pw) {
        // Copy to clipboard
        if (navigator.clipboard) {
            navigator.clipboard.writeText(pw);
        } else {
            // fallback for older browsers
            var temp = document.createElement('input');
            document.body.appendChild(temp);
            temp.value = pw;
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);
        }
        // show copied message
        let msg = document.createElement('span');
        msg.className = 'copied';
        msg.innerText = 'Copied!';
        el.appendChild(msg);
        setTimeout(() => { if (msg.parentNode) msg.parentNode.removeChild(msg); }, 1200);
    }
    </script>
</body>
</html>