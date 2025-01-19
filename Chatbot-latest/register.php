<!-- Main HTML structure for the registration form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Registration Form</title>
    <style>
        /* Global styles and reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Body background with gradient */
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background:  #070707;
        }

        /* Container styling */
        .container {
            width: 100%;
            max-width: 400px;
            padding: 1rem;
            text-align:center;
            position: relative;
        }

        /* Robot image styling */
        img{
            width: 350px;
            height: 350px;
            position: absolute;
            left: -190px;
            top: 15%;
            transform: translateY(-50%);
            transform: rotate( -380deg);
            
          
        }

        /* Form styling */
        .form-container {
            background: rgb(222, 215, 214);
            padding: 2rem;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            
        }

        /* Heading styles */
        h1 {
            color: #fff;
            margin-bottom: 0.5rem;
            font-size: 2rem;
            font-family: "poppins", serif;
            font-weight: 700;

        }

        h2 {
            color: #fff;
            margin-bottom: 3rem;
            font-size: 1rem;
            opacity: 0.8;
            font-family: "poppins", serif;
            font-weight: 400;
            font-style: normal;
        }

        /* Input field styling */
        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        input {
            width: 70%;
            padding: 12px 55px;
            background: linear-gradient(45deg, #bdb8b866, #0000);
            outline: none;
            font-size: 1rem;
            border-radius: 11px;
            border: 2px solid #fff;
            border-width: 2px;
            border-style: solid;
            font-family: "poppins", serif;
         
        }

        /* Input icons */
        .input-group::before {
    content: '';
    position: absolute;
    left: 70px;
    top: 50%;
    transform: translateY(-50%);
    width: 25px;
    height: 25px;
    background-size: cover;
   
}

/* Specific icon for username input */
.input-group:nth-child(1)::before {
    background-image: url('pics/icons8-username-24.png');
    /* Or use a data URI */
    /* background-image: url('data:image/svg+xml;utf8,<svg ... />'); */
}

/* Specific icon for email input */
.input-group:nth-child(2)::before {
    background-image: url('pics/icons8-email-24.png');
}

/* Specific icon for password inputs */
.input-group:nth-child(3)::before,
.input-group:nth-child(4)::before {
    background-image: url('pics/icons8-password-50.png');
}

        /* Button styling */
        .signup-btn {
        width: 70%;
            padding: 10px 55px;
            background: linear-gradient(45deg, #bdb8b866, #0000);
            border: none;
            outline: none;
            color: #fff;
            font-size: 1rem;
            border-radius: 11px;
            border: #fff;
            border: 2px solid #fff;
            border-width: 2px;
            border-style: solid;
            
        }

        .signup-btn:hover {
            background: #357abd;
        }

        /* Login link styling */
        .login-link {
            margin-top: 1.5rem;
            color: #fff;
            text-decoration: none;
        }

        .login-link a {
            color: #4a90e2;
            text-decoration: none;
        }

        
    </style>
</head>
<body>
    <!-- Main container -->
    <div class="container">
        <!-- Robot image placeholder -->
        <div class="robot-image">
          <img src="pics/HD TechBot.png" alt="robot"/>
        </div>

       
            <h1>Register</h1>
            <h2>Please Register to Continue</h2>

            <!-- Registration form -->
            <form id="registerForm">
                <!-- Username input -->
                <div class="input-group">
                    <input type="text" id="username" name="username" required>
                </div>

                <!-- Email input -->
                <div class="input-group">
                    <input type="email" id="email" name="email" required>
                </div>

                <!-- Password input -->
                <div class="input-group">
                    <input type="password" id="password" name="password" required>
                </div>

                <!-- Repeat password input -->
                <div class="input-group">
                    <input type="password" placeholder="Repeat Password" required>
                </div>

                <!-- Sign up button -->
                <button type="submit" class="signup-btn">SIGN UP</button>
            </form>

            <!-- Login link -->
            <div class="login-link">
                <hr style="width:70%; margin: auto">
                <br>
                Already have an account? <a href="login.php">Login Here</a>
            </div>
        </div>
    </div>
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