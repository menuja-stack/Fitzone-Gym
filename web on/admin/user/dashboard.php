<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">User Dashboard</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Available Workout Plans</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        $stmt = $pdo->query("SELECT * FROM workout_plans");
                        while ($plan = $stmt->fetch()) {
                            echo "<div class='card mb-3'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>{$plan['name']}</h5>";
                            echo "<p class='card-text'>{$plan['description']}</p>";
                            echo "<p>Duration: {$plan['duration']} months</p>";
                            echo "<p>Price: ${$plan['price']}</p>";
                            echo "<form action='select_plan.php' method='POST'>";
                            echo "<input type='hidden' name='plan_id' value='{$plan['id']}'>";
                            echo "<button type='submit' class='btn btn-primary'>Select Plan</button>";
                            echo "</form>";
                            echo "</div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Leave Feedback</h4>
                    </div>
                    <div class="card-body">
                        <form action="submit_feedback.php" method="POST">
                            <div class="mb-3">
                                <textarea class="form-control" name="comment" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Feedback</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Your Current Plan</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        $stmt = $pdo->prepare("
                            SELECT wp.*, up.start_date, up.end_date 
                            FROM user_plans up 
                            JOIN workout_plans wp ON up.plan_id = wp.id 
                            WHERE up.user_id = ? AND up.end_date >= CURDATE()
                            ORDER BY up.end_date DESC LIMIT 1
                        ");
                        $stmt->execute([$user_id]);
                        $current_plan = $stmt->fetch();

                        if ($current_plan) {
                            echo "<h5>{$current_plan['name']}</h5>";
                            echo "<p>Start Date: {$current_plan['start_date']}</p>";
                            echo "<p>End Date: {$current_plan['end_date']}</p>";
                        } else {
                            echo "<p>No active plan. Select a plan to get started!</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>