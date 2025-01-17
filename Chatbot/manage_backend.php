<?php
session_start();

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not admin
    exit();
}

// Database connection details
$host = 'localhost:3307';
$dbname = 'itech_chatbot';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Error connecting to database: " . $conn->connect_error);
}

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'create') {
            $question = trim($_POST['question']);
            $answer = trim($_POST['answer']);
            if (!empty($question) && !empty($answer)) {
                $stmt = $conn->prepare("INSERT INTO chatbot (question, answer) VALUES (?, ?)");
                $stmt->bind_param('ss', $question, $answer);
                $stmt->execute();
                $stmt->close();
            }
        } elseif ($action === 'update') {
            $id = intval($_POST['id']);
            $question = trim($_POST['question']);
            $answer = trim($_POST['answer']);
            if ($id && !empty($question) && !empty($answer)) {
                $stmt = $conn->prepare("UPDATE chatbot SET question = ?, answer = ? WHERE id = ?");
                $stmt->bind_param('ssi', $question, $answer, $id);
                $stmt->execute();
                $stmt->close();
            }
        } elseif ($action === 'delete') {
            $id = intval($_POST['id']);
            if ($id) {
                $stmt = $conn->prepare("DELETE FROM chatbot WHERE id = ?");
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// Fetch all chatbot entries
$result = $conn->query("SELECT * FROM chatbot ORDER BY id ASC");

// Prepare data for the frontend
$entries = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }
    $result->free();
}

$conn->close();
echo json_encode($entries); // Send data as JSON
?>
