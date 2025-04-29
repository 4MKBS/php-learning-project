<?php

// Get all recipes
function getAllRecipes($conn) {
    $sql = "SELECT * FROM recipes ORDER BY created_at DESC";
    return $conn->query($sql);
}

// Get a single recipe by ID
function getRecipeById($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Add a new recipe
function addRecipe($conn, $title, $description, $ingredients, $instructions) {
    // echo "<script>alert('Recipe added successfully! model');</script>";
    $stmt = $conn->prepare("INSERT INTO recipes (title, description, ingredients, instructions) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $ingredients, $instructions);
    return $stmt->execute();
}

// Update an existing recipe
function updateRecipe($conn, $id, $title, $description, $ingredients, $instructions) {
    $stmt = $conn->prepare("UPDATE recipes SET title = ?, description = ?, ingredients = ?, instructions = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $title, $description, $ingredients, $instructions, $id);
    return $stmt->execute();
}

// Delete a recipe
function deleteRecipe($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM recipes WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
