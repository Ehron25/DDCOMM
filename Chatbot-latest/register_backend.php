<?php
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
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = 'user'; // Default role

    // Validate inputs
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required.";
        exit();
    }

    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        echo "Username must be 3-20 characters long and can only contain letters, numbers, and underscores.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param('ssss', $username, $email, $hashedPassword, $role);
        if ($stmt->execute()) {
            echo "success";
        } else {
            if ($stmt->errno === 1062) {
                echo "Username or email already exists.";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
