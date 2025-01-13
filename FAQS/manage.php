<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage FAQs</title>
    <link rel="stylesheet" href="css/crudstyles.css">
</head>
<body>
    <div class="container">
        <h1>Manage FAQs</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $mysqli = new mysqli("localhost", "root", "", "faq_chatbot");
                $result = $mysqli->query("SELECT * FROM faqs");

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['question']}</td>
                        <td>{$row['answer']}</td>
                        <td>
                            <a href='edit.php?id={$row['id']}'>Edit</a> |
                            <a href='delete.php?id={$row['id']}'>Delete</a>
                        </td>
                    </tr>";
                }

                $mysqli->close();
                ?>
            </tbody>
        </table>
        <a href="form.php" class="link-button">Add New FAQ</a>
    </div>
</body>
</html>
