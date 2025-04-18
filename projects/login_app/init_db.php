<?php
// Run this file once to initialize the database and users table
$host = "localhost/php-learning-project/projects/login_app";
$user = "root";
$password = "";
$dbname = "login_app";

// Create database
$conn = new mysqli($host, $user, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->close();

// Create users table
$conn = new mysqli($host, $user, $password, $dbname);
$createTable = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($createTable) === TRUE) {
    echo "Database and users table initialized successfully.";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>