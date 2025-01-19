<?php
session_start(); // Start a session to track user data

// Database connection details
$host = 'localhost:3307';
$dbname = 'itech_chatbot';
$username = 'root';
$password = '';

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Error connecting to database: " . $conn->connect_error);
}

// Process POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        echo "All fields are required.";
        exit();
    }

    // Query the database for the username
    $stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword, $role);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Store username and role in session
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            
            echo "success|$role"; // Include role in the response
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that username.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
