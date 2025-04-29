<?php
$view = $_GET['view'] ?? 'index'; // get the file name from the URL, default to 'index'
// Example URL: http://localhost/recipe-management-system/router.php?view=index
// Example URL: http://localhost/recipe-management-system/router.php?view=add
// Example URL: http://localhost/recipe-management-system/router.php?view=edit&id=1
// Example URL: http://localhost/recipe-management-system/router.php?view=delete&id=1
echo "View: $view";
$viewPath = "views/{$view}.php";

// Security check – disallow directory traversal
if (preg_match('/^[a-zA-Z0-9_-]+$/', $view) && file_exists($viewPath)) {
    include $viewPath;
} else {
    include "views/404.php";
}
?>
