<?php
// Database connection configuration
$servername = "127.0.0.1"; // or 'localhost'
$username = "root"; // Default MySQL username
$password = ""; // Leave blank if there's no password
$dbname = "faq_chatbot"; // Change to your database name if needed

// Check if the MySQLi extension is loaded
if (!extension_loaded('mysqli')) {
    die("MySQLi extension is not loaded. Please enable it in your PHP configuration.");
}

// Connect to the database using MySQLi
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error . "<br>");
}

echo "Database connection successful!<br>";

// Verify database selection by querying tables
$result = $mysqli->query("SHOW TABLES");

if ($result && $result->num_rows > 0) {
    echo "Database '$dbname' found with tables.<br>";
} else {
    echo "Database '$dbname' is empty or no tables exist.<br>";
}

// Close the database connection
$mysqli->close();
?>
