<?php
// select_plan.php - Handle plan selection
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $plan_id = $_POST['plan_id'];

    // Get plan duration
    $stmt = $pdo->prepare("SELECT duration FROM workout_plans WHERE id = ?");
    $stmt->execute([$plan_id]);
    $plan = $stmt->fetch();

    $start_date = date('Y-m-d');
    $end_date = date('Y-m-d', strtotime("+{$plan['duration']} days"));

    $stmt = $pdo->prepare("INSERT INTO user_plans (user_id, plan_id, start_date, end_date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $plan_id, $start_date, $end_date]);

    header('Location: user_dashboard.php');
    exit();
}
?>