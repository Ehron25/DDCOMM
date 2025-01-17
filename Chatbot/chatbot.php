<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iTech Chatbot</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="chat-container">
        <h1>iTech Chatbot</h1>
        <div class="chat-box" id="chat-box">
            <!-- Chat messages will appear here -->
        </div>
        <form id="chat-form">
            <input type="text" id="user-input" placeholder="Type your message..." autocomplete="off" required>
            <button type="submit">Send</button>
        </form>

        <?php if ($role === 'admin'): ?>
            <!-- Button for admins to manage the table -->
            <form action="manage.php" method="get" style="margin-top: 20px;">
                <button type="submit">Manage Table</button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        const form = document.getElementById('chat-form');
        const chatBox = document.getElementById('chat-box');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const userInput = document.getElementById('user-input').value.trim();
            addMessage('You: ' + userInput, 'user');

            // Send query to PHP backend
            const response = await fetch('chatbot_backend.php?query=' + encodeURIComponent(userInput));
            const result = await response.text();

            addMessage('Bot: ' + result, 'bot');
            form.reset();
        });

        function addMessage(message, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = sender;
            messageDiv.textContent = message;
            chatBox.appendChild(messageDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    </script>
</body>
</html>
