<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['plan_id']) || !isset($_POST['duration'])) {
    header("Location: subscription_plans.php");
    exit();
}

try {
    // Get plan details
    $stmt = $pdo->prepare("SELECT * FROM plans WHERE id = ?");
    $stmt->execute([$_POST['plan_id']]);
    $plan = $stmt->fetch();

    if (!$plan) {
        throw new Exception("Invalid plan selected");
    }

    $duration_months = intval($_POST['duration']);
    $total_amount = $plan['price_per_month'] * $duration_months;

    // Cancel any active subscriptions
    $stmt = $pdo->prepare("UPDATE subscriptions SET status = 'cancelled' WHERE user_id = ? AND status = 'active'");
    $stmt->execute([$_SESSION['user_id']]);

    // Create new subscription
    $stmt = $pdo->prepare("INSERT INTO subscriptions (user_id, plan_id, start_date, duration_months, total_amount) VALUES (?, ?, CURDATE(), ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $plan['id'], $duration_months, $total_amount]);

    header("Location: user_dashboard.php?success=subscription_added");
} catch(Exception $e) {
    header("Location: subscription_plans.php?error=subscription_failed");
}
exit();
?>