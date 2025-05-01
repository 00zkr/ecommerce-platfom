<?php
// Database credentials
define('DB_HOST', 'localhost');    // Database host (e.g., localhost)
define('DB_NAME', 'ecommerce_db');  // Your database name
define('DB_USERNAME', 'root');   // Your MySQL username
define('DB_PASSWORD', '');   // Your MySQL password

// Create a connection to the database using MySQLi
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Set the character set to UTF-8 for proper encoding
$mysqli->set_charset('utf8');

// Make the connection accessible globally
global $db;
$db = $mysqli;
?>
