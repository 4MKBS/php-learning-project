<?php include '../includes/header.php'; ?>
<?php
require_once '../database/db.php';
require_once '../database/RecipeModel.php';

// Get the recipe ID from the URL
$id = $_GET['id'] ?? 0;
$recipe = getRecipeById($conn, $id);

if (!$recipe) {
    echo "<script>alert('Recipe not found!');</script>";
    echo "<script>window.location.href = '../';</script>";
    exit;
}

// Display the recipe details

echo '<div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded shadow">';
echo '<h1 class="text-3xl font-bold mb-2">' . htmlspecialchars($recipe['title']) . '</h1>';
echo '<p class="text-gray-700 mb-4">' . htmlspecialchars($recipe['description']) . '</p>';
echo '<h2 class="text-xl font-semibold mt-6">Ingredients</h2>';
echo '<ul class="list-disc ml-5 text-gray-800">';
$ingredients = explode(',', $recipe['ingredients']);
foreach ($ingredients as $ingredient) {
    echo '<li>' . htmlspecialchars(trim($ingredient)) . '</li>';
}
echo '</ul>';
echo '<h2 class="text-xl font-semibold mt-6">Instructions</h2>';
echo '<p class="text-gray-800">' . nl2br(htmlspecialchars($recipe['instructions'])) . '</p>';
echo '</div>';




?>

<!-- <div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded shadow">
    <h1 class="text-3xl font-bold mb-2">Sample Recipe Title</h1>
    <p class="text-gray-700 mb-4">Short description of the recipe.</p>

    <h2 class="text-xl font-semibold mt-6">Ingredients</h2>
    <ul class="list-disc ml-5 text-gray-800">
        <li>Ingredient 1</li>
        <li>Ingredient 2</li>
        <li>Ingredient 3</li>
    </ul>

    <h2 class="text-xl font-semibold mt-6">Instructions</h2>
    <p class="text-gray-800">Step-by-step cooking instructions go here.</p>
</div> -->
<?php include '../includes/footer.php'; ?>
