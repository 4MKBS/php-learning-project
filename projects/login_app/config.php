<?php
// Database configuration
$host = "localhost"; // Corrected host
$user = "root";
$password = ""; // Set your MySQL password
$dbname = "login_app";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>