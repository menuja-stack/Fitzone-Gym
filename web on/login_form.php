<?php
include 'config_form.php';

session_start();

if (!isset($conn) || !$conn) {
    die("Database connection failed.");
}

if (isset($_POST['submit'])) {

    // Check if the required fields are set
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $pass = isset($_POST['password']) ? md5($_POST['password']) : '';

    if ($email && $pass) {
        $select = "SELECT * FROM user_form WHERE email='$email' AND password='$pass'";
        $result = mysqli_query($conn, $select);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                header('location:admin_page.php');
                exit;
            } elseif ($row['user_type'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                header('location:user_page.php');
                exit;
            }
        } else {
            $error[] = 'Incorrect email or password!';
        }
    } else {
        $error[] = 'Please enter both email and password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style5.css">
</head>
<body>

<div class="form-container">
    <form action="" method="post">
      <h3>Login Now</h3>
      <?php
        if (isset($error)) {
            foreach ($error as $errorMsg) {
                echo '<span class="error-msg">' . $errorMsg . '</span>';
            }
        }
        ?>
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="Login Now" class="form-btn">
      <p>Don't have an account? <a href="registration_form.php">Register now</a></p>
    </form>
</div>
    
</body>
</html>
