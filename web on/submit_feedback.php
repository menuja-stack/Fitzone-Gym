<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback = $_POST['feedback'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO feedback (user_id, message) VALUES (?, ?)");
    $stmt->execute([$user_id, $feedback]);

    header("Location: user_dashboard.php?success=feedback_submitted");
    exit();
}
?>
