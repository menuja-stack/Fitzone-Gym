<?php
session_start();
require_once 'config.php';

// Function to check user session
function checkUserSession() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php'); // Redirect if not logged in
        exit();
    }
}

checkUserSession();

$errors = [];
$success = false;

try {
    // Fetch plan ID from the URL
    if (isset($_GET['plan_id'])) {
        $plan_id = filter_var($_GET['plan_id'], FILTER_VALIDATE_INT);
        if (!$plan_id) {
            throw new Exception("Invalid plan ID");
        }

        // Fetch plan details
        $sql = "SELECT * FROM plans WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$plan_id]);
        $plan = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$plan) {
            throw new Exception("Plan not found");
        }
    } else {
        throw new Exception("No plan selected");
    }

    // Handle subscription
    if (isset($_POST['subscribe'])) {
        // Validate duration input
        $duration = filter_var($_POST['duration'], FILTER_VALIDATE_INT);
        
        if (!$duration) {
            throw new Exception("Invalid duration");
        }

        $user_id = $_SESSION['user_id'];
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime("+$duration months"));

        // Check if the user already has an active subscription
        $check_sql = "SELECT id FROM subscriptions WHERE user_id = ? AND statues = 'active'";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([$user_id]);
        $existing_sub = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing_sub) {
            throw new Exception("You already have an active subscription");
        }

        // Insert subscription into the database
        $sql = "INSERT INTO subscriptions (user_id, plan_id, start_date, end_months, statues) 
                VALUES (?, ?, ?, ?, 'active')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $plan_id, $start_date, $end_date]);

        $success = true;
        header('Location: user_dashboard.php'); // Redirect to dashboard after success
        exit();
    }

} catch (Exception $e) {
    $errors[] = $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Subscribe</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }

        .alert {
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 6px;
            background-color: #fff;
        }

        .alert-danger {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        h2 {
            color: #1f2937;
            margin-bottom: 24px;
            font-size: 24px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #4b5563;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            font-size: 16px;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            background-color: white;
            transition: border-color 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 40px;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #4b5563;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($plan) && empty($errors)): ?>
            <h2>Subscribe to <?php echo htmlspecialchars($plan['name']); ?></h2>
            <form method="POST" class="needs-validation" novalidate>
                <div class="form-group">
                    <label class="form-label">Duration (months):</label>
                    <select name="duration" class="form-control" required>
                        <option value="1">1 Month</option>
                        <option value="3">3 Months</option>
                        <option value="6">6 Months</option>
                        <option value="12">12 Months</option>
                    </select>
                </div>
                <div class="button-group">
                    <button type="submit" name="subscribe" class="btn btn-primary">Confirm Subscription</button>
                    <a href="plans.php" class="btn btn-secondary">Back to Plans</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>