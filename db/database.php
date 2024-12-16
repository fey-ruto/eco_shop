<?php
// Database credentials
$host = 'localhost'; // Your database host (usually 'localhost')
$username = 'root'; // Your database username
$password = ''; // Your database password
$database = 'ecomaze'; // Your database name

// Establish connection using MySQLi
$db = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($db->connect_error) {
    die('Database connection failed: ' . $db->connect_error);
}

// Set the character set to UTF-8
$db->set_charset('utf8mb4');

// Optional: Uncomment the line below for testing purposes
// echo "Database connection successful!";
?>
