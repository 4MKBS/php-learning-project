<?php
// Database configuration
$host = "localhost";
$user = "root";
$password = ""; // Leave blank for XAMPP
$dbname = "todo_app";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>