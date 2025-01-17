<?php
// Database connection configuration
$host = 'localhost:3307';
$dbname = 'itech_chatbot';
$username = 'root';
$password = ''; 

// Connect to the database using MySQLi
$mysqli = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Process user query
if (isset($_GET['query'])) {
    $userQuery = strtolower(trim($_GET['query']));

    // Search for matching FAQ in the database
    $stmt = $mysqli->prepare("SELECT answer FROM chatbot WHERE LOWER(question) LIKE ?");
    if (!$stmt) {
        die("An error occurred while processing your request.");
    }

    $likeQuery = "%$userQuery%";
    $stmt->bind_param("s", $likeQuery);

    if (!$stmt->execute()) {
        die("An error occurred while processing your request.");
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['answer'];
    } else {
        echo "Sorry, I couldn't find an answer to your question.";
    }

    $stmt->close();
}

// Close the database connection
$mysqli->close();
?>
