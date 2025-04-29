<?php
require 'db.php';
// Handle Add
if (isset($_POST['add'])) {
    $title = trim($_POST['title']);
    $ingredients = trim($_POST['ingredients']);
    $instructions = trim($_POST['instructions']);
    $category = trim($_POST['category']);
    if ($title && $ingredients && $instructions) {
        $stmt = $conn->prepare("INSERT INTO recipes (title, ingredients, instructions, category) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $ingredients, $instructions, $category);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php"); exit;
    }
}
// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM recipes WHERE id=$id");
    header("Location: index.php"); exit;
}
// Load Recipes
$recipes = $conn->query("SELECT * FROM recipes ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Recipe Manager</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f7fa; margin:0; color:#222;}
        .container { max-width: 900px; margin: 30px auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px #c7d2fe55; padding: 28px 20px;}
        h1 { text-align:center; color: #2563eb; margin-bottom: 20px; }
        form { display:flex; flex-wrap:wrap; gap:12px; background:#f1f5f9; border-radius:12px; padding:16px; margin-bottom:36px;}
        input, textarea, select { font-size:1rem; padding:9px; border-radius:7px; border:1px solid #cbd5e1; width:100%; background:#fff;}
        input[type="text"], select { flex:1 1 230px;}
        textarea { flex:1 1 290px; min-height:52px;}
        button { background: #2563eb; color:#fff; border:none; border-radius:7px; padding:10px 18px; cursor:pointer;
            font-size:1.08rem; font-weight:500; transition: background 0.13s;}
        button:hover { background: #1e40af; }
        .recipes { display: grid; gap:24px; grid-template-columns: repeat(auto-fit, minmax(290px,1fr)); }
        .card { background:#f9fafb; border-radius:10px; box-shadow:0 2px 14px #c7d2fe22; padding:18px 13px 13px 18px; position:relative; }
        .card h2 { margin:0 0 8px 0; color:#2563eb; font-size:1.2rem; }
        .category { display:inline-block; background:#e0e7ff; color:#3730a3; border-radius:5px; padding:2px 10px; font-size:0.98em; margin-bottom:7px;}
        .card .delete-btn { position:absolute; top:8px; right:10px; background:#f43f5e; color:#fff; border:none; border-radius:5px; padding:6px 12px; cursor:pointer; font-size:0.96rem;}
        .card .delete-btn:hover { background:#be123c; }
        .card .section { margin:7px 0 0 0; }
        .label { color:#64748b; font-size:0.98em; margin-bottom:2px; }
        @media (max-width:600px) {
            .container { padding:7px 2vw; }
            form { flex-direction:column; gap:8px;}
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🍲 Recipe Management System</h1>
    <form method="post" autocomplete="off">
        <input type="text" name="title" placeholder="Recipe Title" required>
        <input type="text" name="category" placeholder="Category (e.g. Dessert)">
        <textarea name="ingredients" placeholder="Ingredients (one per line)" required></textarea>
        <textarea name="instructions" placeholder="Instructions" required></textarea>
        <button type="submit" name="add">Add Recipe</button>
    </form>
    <div class="recipes">
    <?php if ($recipes->num_rows): foreach ($recipes as $r): ?>
        <div class="card">
            <form method="get" style="position:absolute;top:8px;right:10px;">
                <input type="hidden" name="delete" value="<?= $r['id'] ?>">
                <button class="delete-btn" onclick="return confirm('Delete this recipe?');">Delete</button>
            </form>
            <h2><?= htmlspecialchars($r['title']) ?></h2>
            <?php if ($r['category']): ?><span class="category"><?= htmlspecialchars($r['category']) ?></span><?php endif; ?>
            <div class="section">
                <div class="label">Ingredients:</div>
                <ul style="margin:0 0 0 18px;padding:0;">
                    <?php foreach (explode("\n", $r['ingredients']) as $ing): ?>
                        <li><?= htmlspecialchars(trim($ing)) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="section">
                <div class="label">Instructions:</div>
                <div><?= nl2br(htmlspecialchars($r['instructions'])) ?></div>
            </div>
            <div class="label" style="margin-top:7px; font-size:0.95em;">
                Added on <?= date('M d, Y', strtotime($r['created_at'])) ?>
            </div>
        </div>
    <?php endforeach; else: ?>
        <div style="color:#888;font-size:1.1em;">No recipes yet. Add your first one above!</div>
    <?php endif; ?>
    </div>
</div>
</body>
</html>