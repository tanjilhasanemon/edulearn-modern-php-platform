<?php
// Database Connection File
// Purpose: Establish connection to MySQL database
// This file is included by other PHP files to access the database

// XAMPP Default MySQL Configuration
// Update these values if you've changed your MySQL setup:

$servername = "localhost";      // MySQL Server (XAMPP default: localhost)
$db_user = "root";              // MySQL User (XAMPP default: root)
$db_password = "";              // MySQL Password (XAMPP default: empty)
$db_name = "elearning_db";      // Database name

// Create connection using MySQLi
// NOTE: Using MySQLi Procedural (beginner-friendly)
$connection = mysqli_connect($servername, $db_user, $db_password, $db_name);

// Check if connection failed
if (!$connection) {
    // Log the error (in production, log to file instead of displaying)
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Set character set to UTF-8 for proper handling of special characters
mysqli_set_charset($connection, "utf8mb4");

?>
