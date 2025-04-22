<?php
// Database Configuration
$host = "localhost";
$user = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password is blank
$dbname = "survey_system";

// Create a connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>