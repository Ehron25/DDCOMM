<?php
// Database connection configuration
$host = 'localhost'; // Host
$dbname = 'itech_chatbot'; // Database name
$username = 'root'; // MySQL username
$password = ''; // MySQL password

// Establish a database connection
$mysqli = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Process user query
if (isset($_GET['query'])) {
    $userQuery = strtolower(trim($_GET['query']));

    // Search for a matching response in the database
    $stmt = $mysqli->prepare("SELECT answer FROM chatbot WHERE LOWER(question) LIKE ?");
    $likeQuery = "%$userQuery%";
    $stmt->bind_param("s", $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    // Return a response or a default message
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
