<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'user') {
    header("Location: index.php");
    exit();
}

require_once 'config.php'; // Make sure this defines $pdo

$user_id = $_SESSION['user_id'];
$sql = "SELECT s.*, p.name AS plan_name, p.description 
        FROM subscriptions s 
        JOIN plans p ON s.plan_id = p.id 
        WHERE s.user_id = ? AND s.statues = 'active'"; // Fixed typo from 'statues' to 'status'
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$subscription = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="style8.css" rel="stylesheet">
</head>
<body>

    <nav>
        <div class="container">
            <div class="title">Customer Dashboard</div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="dashboard-card">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <div class="profile-feedback">
                <div class="profile-section">
                    <h3>Your Profile</h3>
                    <p>Username: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    <p>Account Type: Customer</p>
                </div>
                <div class="feedback-section">
                    <h3>Send Feedback</h3>
                    <form action="submit_feedback.php" method="POST">
                        <textarea name="feedback" rows="4" placeholder="Enter your feedback here..." required></textarea>
                        <button type="submit">Submit Feedback</button>
                    </form>
                </div>
            </div>

            <div class="subscription-section">
                <h2>Your Subscription</h2>
                <?php if ($subscription) { ?>
                    <div>
                        <h5><?php echo htmlspecialchars($subscription['plan_name'] ?? 'N/A'); ?></h5>
                        <p><?php echo htmlspecialchars($subscription['description'] ?? 'N/A'); ?></p>
                        <p>Start Date: <?php echo htmlspecialchars($subscription['start_date'] ?? 'N/A'); ?></p>
                        <p>End Date: <?php echo htmlspecialchars($subscription['end_months'] ?? 'N/A'); ?></p>
                        <p>Status: <?php echo htmlspecialchars($subscription['statues'] ?? 'N/A'); ?></p>
                    </div>
                <?php } else { ?>
                    <p>You don't have an active subscription.</p><br>
                    <a href="plans.php" class="view-plans-btn">View Plans</a>
                <?php } ?>
            </div>
        </div>
    </div>

</body>
</html>

