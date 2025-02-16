<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    switch($action) {
        case 'add_user':
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user_type = isset($_POST['is_admin']) ? 'admin' : 'user';

            try {
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)");
                $stmt->execute([$username, $email, $password, $user_type]);
                header("Location: admin_dashboard.php?success=user_added");
            } catch(PDOException $e) {
                header("Location: admin_dashboard.php?error=user_exists");
            }
            break;

        case 'toggle_admin':
            $user_id = $_POST['user_id'];
            
            // Get current user type
            $stmt = $pdo->prepare("SELECT user_type FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();
            
            // Toggle user type
            $new_type = $user['user_type'] == 'admin' ? 'user' : 'admin';
            
            $stmt = $pdo->prepare("UPDATE users SET user_type = ? WHERE id = ?");
            $stmt->execute([$new_type, $user_id]);
            header("Location: admin_dashboard.php?success=user_updated");
            break;

        case 'delete_user':
            $user_id = $_POST['user_id'];
            
            // First delete any feedback from this user
            $stmt = $pdo->prepare("DELETE FROM feedback WHERE user_id = ?");
            $stmt->execute([$user_id]);
            
            // Then delete the user
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            header("Location: admin_dashboard.php?success=user_deleted");
            break;

        
        
            case 'cancel_subscription':
                $subscription_id = $_POST['subscription_id'];
                $stmt = $pdo->prepare("UPDATE subscriptions SET status = 'cancelled' WHERE id = ?");
                $stmt->execute([$subscription_id]);
                header("Location: admin_dashboard.php?success=subscription_cancelled");
                break;
            
    }
    exit();
}
?>