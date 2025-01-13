<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>League of Legends FAQ Chatbot</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="chat-container">
        <h1>League of Legends FAQ Chatbot</h1>
        <div class="chat-box" id="chat-box">
            <!-- Chat messages will appear here -->
        </div>
        <form id="chat-form">
            <input type="text" id="user-input" placeholder="Ask a question..." autocomplete="off" required>
            <button type="submit">Send</button>
        </form>
    </div>

    <script>
        const form = document.getElementById('chat-form');
        const chatBox = document.getElementById('chat-box');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const userInput = document.getElementById('user-input').value.trim();
            addMessage('You: ' + userInput, 'user');

            // Send query to PHP backend
            const response = await fetch('process_chat.php?query=' + encodeURIComponent(userInput));
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
