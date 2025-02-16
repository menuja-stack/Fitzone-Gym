<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
    <style>
        /* Reset some default styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .login-box {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .input-group {
            margin-bottom: 1rem;
            text-align: left;
        }

        .input-group label {
            font-size: 1rem;
            color: #555;
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            color: #333;
        }

        .input-group input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 5px rgba(59, 130, 246, 0.3);
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .button-group button {
            background-color: #3b82f6;
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .button-group button:hover {
            background-color: #2563eb;
        }

        .button-group a {
            color: #3b82f6;
            font-weight: bold;
            font-size: 1rem;
            text-decoration: none;
        }

        .button-group a:hover {
            text-decoration: underline;
            color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>Login</h2>
            <form action="login_process.php" method="POST">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="button-group">
                    <button type="submit">Sign In</button>
                    <a href="register.php">Register</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
