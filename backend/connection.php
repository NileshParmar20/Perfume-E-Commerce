<?php 
$server = "localhost";
$user = "root";
$password = "";
$database = "perfumeshop";

// Create connection
$conn = new mysqli($server, $user, $password, $database);

// Check connection and debug if it fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to avoid character encoding issues
$conn->set_charset("utf8mb4");
?>
