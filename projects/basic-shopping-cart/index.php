<?php
session_start();

// Dummy product catalog
$products = [
    1 => ["name" => "Apple",  "price" => 0.99],
    2 => ["name" => "Banana", "price" => 0.59],
    3 => ["name" => "Orange", "price" => 0.79],
    4 => ["name" => "Milk",   "price" => 1.99],
    5 => ["name" => "Bread",  "price" => 2.49],
];

// Initialize cart
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Add to cart
if (isset($_POST['add'])) {
    $id = intval($_POST['product_id']);
    $qty = max(1, intval($_POST['quantity']));
    if (isset($products[$id])) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] += $qty;
        } else {
            $_SESSION['cart'][$id] = $qty;
        }
    }
    header("Location: ".$_SERVER['PHP_SELF']); exit;
}

// Remove from cart
if (isset($_POST['remove'])) {
    $id = intval($_POST['product_id']);
    unset($_SESSION['cart'][$id]);
    header("Location: ".$_SERVER['PHP_SELF']); exit;
}

// Update cart
if (isset($_POST['update'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        $id = intval($id);
        $qty = max(1, intval($qty));
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = $qty;
        }
    }
    header("Location: ".$_SERVER['PHP_SELF']); exit;
}

// Clear cart
if (isset($_POST['clear'])) {
    $_SESSION['cart'] = [];
    header("Location: ".$_SERVER['PHP_SELF']); exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Basic Shopping Cart</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5fa; color: #222; margin: 0; }
        .container { max-width: 700px; margin: 30px auto; background: #fff; box-shadow: 0 4px 18px #cdd2db44; border-radius: 13px; padding: 24px; }
        h1 { text-align: center; color: #2563eb; }
        h2 { color: #222; margin-top: 36px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px;}
        th, td { padding: 10px; text-align: center; }
        th { background: #2563eb; color: #fff; }
        tr:nth-child(even) { background: #f1f5f9; }
        tr:nth-child(odd) { background: #fff; }
        .product-list { margin-bottom: 30px; }
        .cart-actions { display: flex; gap: 12px; justify-content: flex-end; }
        .cart-actions button, .product-list button, .remove-btn {
            background: #2563eb; color: #fff; border: none; padding: 7px 18px; border-radius: 5px;
            font-size: 1rem; cursor: pointer; transition: background 0.17s;
        }
        .cart-actions button:hover, .product-list button:hover, .remove-btn:hover { background: #1e40af; }
        .remove-btn { background: #e11d48; margin: 0; padding: 7px 12px; border-radius: 5px; font-size: 0.95rem;}
        .remove-btn:hover { background: #991b1b; }
        input[type="number"] { width: 60px; padding: 5px; border-radius: 5px; border: 1px solid #d1d5db; font-size: 1rem;}
        .empty { text-align: center; color: #888; margin: 25px 0; }
        @media (max-width:600px) {
            .container { padding: 10px; }
            table, thead, tbody, th, td, tr { display: block; }
            th { position: absolute; left: -9999px; }
            tr { margin-bottom: 13px; border-bottom: 2px solid #e5e7eb; }
            td { border-bottom: 1px solid #e5e7eb; position: relative; padding-left: 50%; text-align: left;}
            td:before { position: absolute; top: 10px; left: 10px; width: 45%; white-space: nowrap; font-weight: 700;}
            td:nth-of-type(1):before { content: "Product"; }
            td:nth-of-type(2):before { content: "Price"; }
            td:nth-of-type(3):before { content: "Quantity"; }
            td:nth-of-type(4):before { content: "Total"; }
            td:nth-of-type(5):before { content: "Remove"; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🛒 Basic Shopping Cart</h1>

    <h2>Products</h2>
    <table class="product-list">
        <thead>
        <tr><th>Product</th><th>Price</th><th>Add to Cart</th></tr>
        </thead>
        <tbody>
        <?php foreach ($products as $id=>$p): ?>
            <tr>
                <td><?php echo htmlspecialchars($p['name']); ?></td>
                <td>$<?php echo number_format($p['price'],2); ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?= $id ?>">
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="submit" name="add">Add</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Your Cart</h2>
    <?php if (empty($_SESSION['cart'])): ?>
        <div class="empty">Your cart is empty.</div>
    <?php else: ?>
        <form method="post">
        <table>
            <thead>
            <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Remove</th></tr>
            </thead>
            <tbody>
            <?php $grand = 0; foreach ($_SESSION['cart'] as $id => $qty): ?>
                <tr>
                    <td><?php echo htmlspecialchars($products[$id]['name']); ?></td>
                    <td>$<?php echo number_format($products[$id]['price'],2); ?></td>
                    <td>
                        <input type="number" name="quantities[<?php echo $id; ?>]" value="<?php echo $qty; ?>" min="1">
                    </td>
                    <td>
                        $<?php echo number_format($products[$id]['price'] * $qty,2); $grand += $products[$id]['price'] * $qty; ?>
                    </td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                            <button type="submit" name="remove" class="remove-btn">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" style="text-align:right;"><b>Grand Total:</b></td>
                <td colspan="2"><b>$<?php echo number_format($grand,2); ?></b></td>
            </tr>
            </tbody>
        </table>
        <div class="cart-actions">
            <button type="submit" name="update">Update Cart</button>
            <button type="submit" name="clear" style="background:#e11d48;">Clear Cart</button>
        </div>
        </form>
    <?php endif; ?>
</div>
</body>
</html>