<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form id="loginForm">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Login</button>
    </form>

    <p id="responseMessage"></p>
    
    <script>
        document.getElementById('loginForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(event.target);
            const response = await fetch('login_backend.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.text();
            const [status, role] = result.split('|');

            if (status === 'success') {
                document.getElementById('responseMessage').innerText = `Login successful! Redirecting...`;
                // Redirect to chatbot.php after 1 second
                setTimeout(() => {
                    window.location.href = 'chatbot.php';
                }, 1000);
            } else {
                document.getElementById('responseMessage').innerText = result;
            }
        });
    </script>
</body>
</html>
