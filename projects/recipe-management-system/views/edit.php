<?php include '../includes/header.php'; ?>
<?php
require_once '../database/db.php';
require_once '../database/RecipeModel.php';
// Get the recipe ID from the URL
$id = $_GET['id'] ?? 0;
$recipe = getRecipeById($conn, $id);
// echo "<script>alert('Recipe ID: $id');</script>";
// echo "<script>alert('Recipe: " . json_encode($recipe) . "');</script>";
if (!$recipe) {
    echo "<script>alert('Recipe not found!');</script>";
    echo "<script>window.location.href = '../';</script>";
    exit;
}
// place items data in the input fields
$title = htmlspecialchars($recipe['title']);
$description = htmlspecialchars($recipe['description']);
$ingredients = htmlspecialchars($recipe['ingredients']);
$instructions = htmlspecialchars($recipe['instructions']);

// Pre-fill the form fields with the recipe data

?>
<div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-semibold mb-4">Edit Recipe</h2>
    <form action="../controllers/RecipeController.php?action=edit&id=<?php echo $id; ?>" method="POST" class="space-y-4">
        <input name="title" type="text" value="<?php echo $title; ?>" class="w-full p-2 border rounded" />
        <textarea name="description" class="w-full p-2 border rounded"><?php echo $description; ?></textarea>
        <textarea name="ingredients" class="w-full p-2 border rounded"><?php echo $ingredients; ?></textarea>
        <textarea name="instructions" class="w-full p-2 border rounded"><?php echo $instructions; ?></textarea>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update Recipe</button>
    </form>
</div>
<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('input[name="title"]').value = "<?php echo $title; ?>";
        document.querySelector('textarea[name="description"]').textContent = "<?php echo $description; ?>";
        document.querySelector('textarea[name="ingredients"]').textContent = "<?php echo $ingredients; ?>";
        document.querySelector('textarea[name="instructions"]').textContent = "<?php echo $instructions; ?>";
    });
</script> -->






<!-- <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-semibold mb-4">Edit Recipe</h2>
    <form action="../controllers/RecipeController.php?action=edit&id=<?php echo $_GET['id']; ?>" method="POST" class="space-y-4">
        <input name="title" type="text" value="Sample Title" class="w-full p-2 border rounded" />
        <textarea name="description" class="w-full p-2 border rounded">Sample description</textarea>
        <textarea name="ingredients" class="w-full p-2 border rounded">Sample, ingredients</textarea>
        <textarea name="instructions" class="w-full p-2 border rounded">Sample instructions</textarea>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update Recipe</button>
    </form>
</div> -->

<?php include '../includes/footer.php'; ?>
