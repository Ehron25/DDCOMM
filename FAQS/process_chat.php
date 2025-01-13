<?php
$host = 'localhost';
$dbname = 'faq_chatbot';
$username = 'root';
$password = '';

// Connect to the database using MySQLi
$mysqli = new mysqli($host, $username, $password, $dbname);

// Process user query
if (isset($_GET['query'])) {
    $userQuery = strtolower(trim($_GET['query']));

    // Search for matching FAQ in the database
    $stmt = $mysqli->prepare("SELECT answer FROM faqs WHERE LOWER(question) LIKE ?");
    $likeQuery = "%$userQuery%";
    $stmt->bind_param("s", $likeQuery);
    $stmt->execute();
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
