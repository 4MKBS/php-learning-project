<?php
require_once '../database/db.php';
require_once '../database/RecipeModel.php';

// Get action from URL (e.g., ?action=add)
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $ingredients = $_POST['ingredients'];
            $instructions = $_POST['instructions'];
            // before inserting i want to show alert

            // echo "<script>alert('Recipe added successfully!');</script>";
            if (addRecipe($conn, $title, $description, $ingredients, $instructions)) {
                echo "<script>alert('Recipe added successfully! sakib');</script>";
                // reedirect to the recipe list page using window.location.href
                echo "<script>window.location.href = '../';</script>";
                exit;
            } else {
                echo "Error adding recipe.";
            }
        }
        break;

    case 'edit':
        $id = $_GET['id'] ?? 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $ingredients = $_POST['ingredients'];
            $instructions = $_POST['instructions'];
            if (updateRecipe($conn, $id, $title, $description, $ingredients, $instructions)) {
                echo "<script>alert('Recipe updated successfully!');</script>";
                // Redirect to the recipe view page
                echo "<script>window.location.href = '../views/view.php?id=$id';</script>";
                // header("Location: /view?id=$id");
                exit;
            } else {
                echo "Error updating recipe.";
            }
        }
        break;

    case 'delete':
        $id = $_GET['id'] ?? 0;
        // Confirm deletion with a secret word
        // $secret = "MKBS";
        // $userSecret;
        
        // echo "<script>
        //     var userSecret = prompt('Please enter the secret word to confirm deletion:');
        //     document.cookie = 'userSecret=' + userSecret;
        // </script>";

        // $userSecret = $_COOKIE['userSecret'] ?? '';
        // echo "<script>alert('Secret word: $userSecret');</script>";

        // if($secret === $userSecret) {
           if(deleteRecipe($conn, $id)){
            echo "<script>alert('Recipe deleted successfully!');</script>";

            // Redirect to the recipe list page
            echo "<script>window.location.href = '../';</script>";
            // header("Location: ../");
            exit;
        } else {
            echo "<script>alert('Recipe not deleted.');</script>";
            // Redirect to the recipe list page
            echo "<script>window.location.href = '../';</script>";
            // header("Location: ../");
            exit;
        }
        break;

    default:
        header("Location: ../404.php");
        exit;
}
?>
