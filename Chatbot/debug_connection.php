<?php
$host = 'localhost:3307';  // Database host
$dbname = 'itech_chatbot';  // Database name
$username = 'root';         // MySQL username
$password = '';  // MySQL password

// Try connecting to the MySQL server
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    // Output detailed error
    echo "<strong>Connection failed!</strong><br>";
    echo "<strong>Host Info:</strong> " . $conn->host_info . "<br>";
    echo "<strong>Server Info:</strong> " . $conn->server_info . "<br>";
    echo "<strong>Error:</stron g> " . $conn->connect_error . "<br>";
    echo "<strong>Error Code:</strong> " . $conn->connect_errno . "<br>";
    exit();  // Stop further execution if connection fails
} else {
    // Connection was successful
    echo "<strong>Connection successful!</strong><br>";
    echo "<strong>Host Info:</strong> " . $conn->host_info . "<br>";
    echo "<strong>Server Info:</strong> " . $conn->server_info . "<br>";
}

// Close the connection
$conn->close();
?>
