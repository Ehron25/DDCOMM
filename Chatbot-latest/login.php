<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(180deg, #000000, #3d3d3d);
            color: white;
            text-align: center;
        }

        .container {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 400px; /* To keep things compact */
            transform: scale(0.75); /* Scales content to 75% */
        }

        h1 {
            font-size: 36px;
            margin: 0;
            font-weight: bold;
            letter-spacing: 0.05em; /* Ensure no excessive spacing issues */
        }

        p.subtitle {
            margin: 10px 0 20px;
            color: #cccccc;
            font-size: 18px;
            letter-spacing: 0.05em; /* Adjusted for readability */
        }

        .robot {
            width: 100%;
            max-width: 300px;
            margin-top: 20px;
            margin-bottom: -40px;
        }

        form {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 10px;
    transform: translateX(-10px); /* Moves the entire form 10 pixels to the right */
}


        .input-container {
            position: relative;
            width: 100%;
            margin: 10px 0;
        }

        .input-container img {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 25px;
            height: 25px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 2px solid white;
            border-radius: 5px;
            outline: none;
            background: linear-gradient(90deg, #5a5a5a, #000000);
            color: white;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            letter-spacing: normal; /* No extra spacing */
        }

.or-section {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 20px 0;
    font-size: 14px;
    color: #cccccc;
    text-align: center;
}




        .social-login {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 10px;
        }

        .icon-circle {
            width: 40px;
            height: 40px;
            background-color: #cacaca;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .icon-circle img {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        .register {
            margin-top: 20px;
            font-size: 14px;
        }

        .register a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }

        .register a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>LOG IN</h1>
        <p class="subtitle">Please log in to continue</p>

        <img src="pics/eric/robot.png" alt="Robot" class="robot" />

        <form id="loginForm">
            <div class="input-container">
                <img src="pics/eric/username-icon.png" alt="Username Icon" />
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-container">
                <img src="pics/eric/lock-icon.png" alt="Password Icon" />
                <input type="password" id="password" name="password" required>
            </div>
        </form>

        <p id="responseMessage"></p>
            <p>Or Login With</p>
        <div class="social-login">
            <div class="icon-circle">
                <img src="pics/eric/google-icon.png" alt="Google" />
            </div>
            <div class="icon-circle">
                <img src="pics/eric/facebook-icon.png" alt="Facebook" />
            </div>
        </div>

        <div class="register">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </div>
    <script>
    // Add event listener for the Enter key
    document.getElementById('loginForm').addEventListener('keydown', async (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();

            const formData = new FormData(document.getElementById('loginForm'));
            const response = await fetch('login_backend.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.text();
            const [status, role] = result.split('|');

            if (status === 'success') {
                document.getElementById('responseMessage').innerText = 'Login successful! Redirecting...'; // Add quotes around the message
                // Redirect to chatbot.php after 1 second
                setTimeout(() => {
                    window.location.href = 'chatbot.php';
                }, 1000);
            } else {
                document.getElementById('responseMessage').innerText = result;
            }
        }
    });
</script>

</body>
</html>
