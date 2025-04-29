<?php
$host = 'localhost';
$user = 'root';      // Change to your DB user
$pass = '';          // Change to your DB password
$dbname = 'recipe_db';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>