<?php
$mysqli = new mysqli("localhost", "root", "", "faq_chatbot");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $mysqli->query("SELECT * FROM faqs WHERE id = $id");
    $row = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $question = $mysqli->real_escape_string($_POST['question']);
    $answer = $mysqli->real_escape_string($_POST['answer']);

    $mysqli->query("UPDATE faqs SET question='$question', answer='$answer' WHERE id=$id");

    header("Location: manage.php");
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit FAQ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit FAQ</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="question">Question:</label>
            <input type="text" id="question" name="question" value="<?php echo $row['question']; ?>" required>

            <label for="answer">Answer:</label>
            <textarea id="answer" name="answer" required><?php echo $row['answer']; ?></textarea>

            <button type="submit">Update FAQ</button>
        </form>
        <a href="manage.php" class="link-button">Back to Manage FAQs</a>
    </div>
</body>
</html>
