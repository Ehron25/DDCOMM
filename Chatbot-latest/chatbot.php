<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$role = $_SESSION['role'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <title>TechBot</title>
    <link rel="stylesheet" href="css/chatbot.css">
</head>
<body>
    <div class="buttons">
    <?php if ($role === 'admin'): ?>
        <button class="manage-button" onclick="window.location.href='manage.php'">Manage Table</button>
    <?php endif; ?>
    <button class="logout-button" onclick="window.location.href='login.php'">Log Out</button>
    </div>
    <div class="container">
        <img class="TechBot" src="pics/techbot.png" alt="TechBot">
        <div class="chat-container">
            <div class="chat-header">
                <img src="pics/techbot-head.png" alt="TechBot Head" class="bot-head">
                <h2>TechBot</h2>
                <img width="40" height="40" src="https://img.icons8.com/ios/50/FFFFFF/ellipsis.png" alt="ellipsis" class="dots">
            </div>  

            <hr class="line">

            <div class="chat-body" id="chat-box">
                <div class="bot-message">
                    <img src="pics/techbotright.png" alt="Bot Avatar" class="bot-avatar">
                    <div class="bmessage">
                        Hi <?php echo htmlspecialchars($username); ?>, TechBot is Here! Instant answers, friendly conversation are assured by me!
                    </div>
                </div>
            </div>

            <div class="chat-footer">
                <img width="32" height="32" src="https://img.icons8.com/plumpy/24/add--v1.png" alt="add" class="add">
                <input type="text" placeholder="Type a message" class="chat-input" id="user-input" autocomplete="off">
                <img width="30" height="30" src="https://img.icons8.com/plumpy/24/sent.png" alt="sent" class="sent" id="send-button">
            </div>
        </div>
    </div>

    <script>
        const chatBox = document.getElementById('chat-box');
        const userInput = document.getElementById('user-input');
        const sendButton = document.getElementById('send-button');

        function addMessage(message, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = sender === 'user' ? 'user-message' : 'bot-message';

            const messageContent = document.createElement('div');
            messageContent.className = sender === 'user' ? 'message' : 'bmessage';
            messageContent.textContent = message;

            if (sender === 'bot') {
                const botAvatar = document.createElement('img');
                botAvatar.src = 'pics/techbotright.png';
                botAvatar.alt = 'Bot Avatar';
                botAvatar.className = 'bot-avatar';
                messageDiv.appendChild(botAvatar);
            }

            messageDiv.appendChild(messageContent);
            chatBox.appendChild(messageDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        sendButton.addEventListener('click', async () => {
            const query = userInput.value.trim();
            if (query) {
                addMessage(query, 'user');
                userInput.value = '';

                try {
                    const response = await fetch('chatbot_backend.php?query=' + encodeURIComponent(query));
                    const result = await response.text();
                    addMessage(result, 'bot');
                } catch (error) {
                    addMessage("Sorry, I couldn't connect to the server.", 'bot');
                }
            }
        });
    </script>
</body>
</html>
