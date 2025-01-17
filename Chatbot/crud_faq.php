<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Manage iTech Campus FAQs</title>
</head>
<body>
    <h1>Manage FAQs for iTech Campus Chatbot</h1>

    <form method="POST" action="../crud_faq_backend.php">
        <label for="question">Question:</label><br>
        <input type="text" id="question" name="question" required><br>
        <label for="answer">Answer:</label><br>
        <textarea id="answer" name="answer" required></textarea><br>
        <button type="submit" name="add_faq">Add FAQ</button>
    </form>

    <h2>FAQ List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Question</th>
            <th>Answer</th>
            <th>Action</th>
        </tr>
        <?php
        include_once '../db_config.php';
        $faqs = $conn->query("SELECT * FROM faqs");

        while ($row = $faqs->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['question']}</td>
                    <td>{$row['answer']}</td>
                    <td><a href='..
                    /crud_faq_backend.php?delete={$row['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
