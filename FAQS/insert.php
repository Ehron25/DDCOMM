<?php
$host = 'localhost';
$dbname = 'faq_chatbot';
$username = 'root';
$password = '';

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = $mysqli->real_escape_string(trim($_POST['question']));
    $answer = $mysqli->real_escape_string(trim($_POST['answer']));

    $stmt = $mysqli->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
    $stmt->bind_param("ss", $question, $answer);

    if ($stmt->execute()) {
        echo "FAQ added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
<a href="form.php" class="link-button">Back to Form</a>
<a href="manage.php" class="link-button">Manage FAQs</a>
