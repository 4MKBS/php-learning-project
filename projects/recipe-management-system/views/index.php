<?php include '../includes/header.php'; ?>
<div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded shadow">
    <h2 class="text-3xl font-semibold mb-4">Recipe List</h2>
    <a href="./add.php" class="inline-block mb-6 text-white bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">Add New Recipe</a>
    
    <div class="space-y-4">

         <?php
            require_once '../database/db.php';
            require_once '../database/RecipeModel.php';
            $allRecipes = getAllRecipes($conn);
            if ($allRecipes->num_rows > 0) {
                while ($recipe = $allRecipes->fetch_assoc()) {
                    echo '<div class="p-4 bg-gray-100 rounded shadow-sm hover:bg-gray-200 transition">';
                    echo '<h3 class="text-xl font-semibold">' . htmlspecialchars($recipe['title']) . '</h3>';
                    echo '<p class="text-sm text-gray-600">' . htmlspecialchars($recipe['description']) . '</p>';
                    echo '<div class="mt-2">';
                    echo '<a href="./view.php?id=' . $recipe['id'] . '" class="text-blue-500 hover:underline">View</a> | ';
                    echo '<a href="./edit.php?id=' . $recipe['id'] . '" class="text-yellow-600 hover:underline">Edit</a> | ';
                    echo '<a href="../controllers/RecipeController.php?action=delete&id=' . $recipe['id'] . '" class="text-red-600 hover:underline" onclick="return confirm(\'Are you sure you want to delete this recipe?\');">Delete</a>';
                    // echo '<script>
                    //     function confirmDelete(recipeId) {
                    //         const secretWord = prompt("What is the secret word?");
                    //         if (secretWord === "yourSecretWord") { // Replace "yourSecretWord" with your actual secret word
                    //             window.location.href = "./delete.php?id=" + recipeId;
                    //         } else {
                    //             alert("Incorrect secret word. Deletion canceled.");
                    //         }
                    //     }
                    // </script>';
                    echo '</div></div>';
                }
            } else {
                echo '<p>No recipes found.</p>';
            }
         ?>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
