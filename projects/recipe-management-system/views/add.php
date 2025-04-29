<?php include '../includes/header.php'; ?>
<div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-semibold mb-4">Add New Recipe</h2>
    <form action="../controllers/RecipeController.php?action=add" method="POST" class="space-y-4">
        <input name="title" type="text" placeholder="Recipe Title" required class="w-full p-2 border rounded" />
        <textarea name="description" placeholder="Description" required class="w-full p-2 border rounded"></textarea>
        <textarea name="ingredients" placeholder="Ingredients (comma-separated)" required class="w-full p-2 border rounded"></textarea>
        <textarea name="instructions" placeholder="Instructions" required class="w-full p-2 border rounded"></textarea>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Recipe</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
