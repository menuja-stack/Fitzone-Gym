<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Login System</title>
    <style>
        /* General reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            font-size: 1.75rem;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-weight: bold;
            color: #555;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            color: #333;
        }

        input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 5px rgba(59, 130, 246, 0.3);
        }

        .button-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .button {
            background-color: #3b82f6;
            color: #fff;
            font-weight: bold;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #2563eb;
        }

        .link {
            color: #3b82f6;
            font-weight: bold;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .link:hover {
            text-decoration: underline;
            color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="register_process.php" method="POST">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="button-container">
                <button class="button" type="submit">Register</button>
                <a class="link" href="index.php">Back to Login</a>
            </div>
        </form>
    </div>
</body>
</html>
