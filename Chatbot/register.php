<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form id="registerForm">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Register</button>
    </form>

    <p id="responseMessage"></p>

    <script>
        document.getElementById('registerForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(event.target);

            try {
                const response = await fetch('register_backend.php', {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.text();
                const responseMessage = document.getElementById('responseMessage');

                responseMessage.innerText = result === 'success' 
                    ? 'Registration successful!' 
                    : result;

                if (result === 'success') {
                    responseMessage.style.color = 'green';
                } else {
                    responseMessage.style.color = 'red';
                }
            } catch (error) {
                document.getElementById('responseMessage').innerText = 'An error occurred. Please try again.';
            }
        });
    </script>
</body>
</html>
