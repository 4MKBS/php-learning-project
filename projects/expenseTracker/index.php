<?php
session_start();
if (!isset($_SESSION['expenses'])) $_SESSION['expenses'] = [];// Initialize expenses array



// Add new expense
if (isset($_POST['add'])) {     // Check if form is submitted
    $desc = trim($_POST['description'] ?? '');// Get description
    $amount = floatval($_POST['amount'] ?? 0);
    $date = $_POST['date'] ?? date('Y-m-d');
    if ($desc && $amount > 0) {// Validate inputs
        $_SESSION['expenses'][] = [// Add new expense to session
            'description' => htmlspecialchars($desc),
            'amount' => $amount,
            'date' => $date ?: date('Y-m-d')
        ];
    }
    header("Location: ".$_SERVER['PHP_SELF']); exit;// Redirect to avoid form resubmission
}

// Delete expense
if (isset($_POST['delete'])) {
    $idx = intval($_POST['delete']);
    if (isset($_SESSION['expenses'][$idx])) {
        array_splice($_SESSION['expenses'], $idx, 1);
    }
    header("Location: ".$_SERVER['PHP_SELF']); exit;
}

// Calculate total
$total = 0;
foreach ($_SESSION['expenses'] as $exp) $total += $exp['amount'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Expense Tracker</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: linear-gradient(135deg, #f8fafc 60%, #c7d2fe 100%); margin:0; color:#222;}
        .container { max-width: 500px; margin: 36px auto; background: #fff; border-radius: 14px; box-shadow: 0 4px 24px #a5b4fc33; padding: 26px 20px 34px 20px;}
        h1 { text-align:center; margin-bottom:18px; color: #2563eb; }
        form { display:flex; gap:9px; flex-wrap:wrap; margin-bottom: 24px; }
        input[type="text"], input[type="number"], input[type="date"] {
            flex:1 1 110px; border:1px solid #cbd5e1; border-radius:7px; padding:10px; font-size:1rem; background: #f1f5f9;}
        button { background: #2563eb; color:#fff; border:none; border-radius:7px; padding:10px 18px; cursor:pointer; font-size:1.08rem; font-weight:500;
            transition: background 0.13s;}
        button:hover { background: #1e40af; }
        .summary { background: #f1f5f9; border-radius:8px; padding:14px 0; text-align:center; margin-bottom:22px; color: #2563eb; font-size:1.12rem; font-weight:600;}
        table { width:100%; border-collapse:collapse; background: #fafbfc; border-radius:10px; box-shadow: 0 2px 12px #c7d2fe22;}
        th, td { padding:11px 6px; text-align:center;}
        th { background: #2563eb; color:#fff; font-weight:600;}
        tr:nth-child(even) { background: #f1f5f9;}
        tr:nth-child(odd) { background: #fff;}
        .delete-btn { background:#f43f5e; color:#fff; border:none; border-radius:5px; padding:7px 13px; cursor:pointer; font-size:1rem;}
        .delete-btn:hover { background:#be123c; }
        .empty { text-align:center; color:#888; margin: 20px 0; }
        @media (max-width:600px) {
            .container { padding:8px 2vw 16px 2vw; }
            form { flex-direction:column; gap:7px;}
            th, td { font-size:0.98rem; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>💸 Expense Tracker</h1>
    <div class="summary">
        Total Expenses: $<?php echo number_format($total,2); ?>
    </div>
    <form method="post" autocomplete="off">
        <input type="text" name="description" placeholder="Description" required>
        <input type="number" name="amount" placeholder="Amount ($)" min="0.01" step="0.01" required>
        <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
        <button type="submit" name="add">Add</button>
    </form>
    <?php if (empty($_SESSION['expenses'])): ?>
        <div class="empty">No expenses yet.</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount ($)</th>
                    <th>Date</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($_SESSION['expenses'] as $i=>$exp): ?>
                <tr>
                    <td><?php echo $exp['description']; ?></td>
                    <td><?php echo number_format($exp['amount'],2); ?></td>
                    <td><?php echo $exp['date']; ?></td>
                    <td>
                        <form method="post" style="margin:0;">
                            <button type="submit" name="delete" value="<?php echo $i; ?>" class="delete-btn"
                                onclick="return confirm('Delete this expense?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>