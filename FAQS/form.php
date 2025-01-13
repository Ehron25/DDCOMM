<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add FAQ</title>
    <link rel="stylesheet" href="css/crudstyles.css">
</head>
<body>
    <div class="container">
        <h1>Add New FAQ</h1>
        <form action="insert.php" method="POST">
            <label for="question">Question:</label>
            <input type="text" id="question" name="question" required>

            <label for="answer">Answer:</label>
            <textarea id="answer" name="answer" required></textarea>

            <button type="submit">Add FAQ</button>
        </form>
        <br>
        <a href="manage.php" class="link-button">Manage FAQs</a>
    </div>
</body>
</html>
