<?php
session_start();
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

if (isset($_POST['add_plan'])) {
    $plan_name = $_POST['plan_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "INSERT INTO subscription_plans (plan_name, description, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $plan_name, $description, $price);
    
    if ($stmt->execute()) {
        $success = "Plan added successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Subscription Plan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Subscription Plan</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Plan Name:</label>
                <input type="text" name="plan_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Description:</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Price per Month (Rs):</label>
                <input type="number" name="price" step="0.01" class="form-control" required>
            </div>
            <button type="submit" name="add_plan" class="btn btn-primary">Add Plan</button>
        </form>
    </div>
</body>
</html>

<!-- admin_dashboard.php - Admin dashboard to view subscriptions -->
<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

$sql = "SELECT s.*, u.username, p.plan_name 
        FROM subscriptions s 
        JOIN users u ON s.user_id = u.id 
        JOIN subscription_plans p ON s.plan_id = p.id 
        ORDER BY s.start_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: #f9fafb;
            color: #1f2937;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #111827;
            margin-bottom: 24px;
            font-size: 24px;
            font-weight: 600;
        }

        .header-actions {
            margin-bottom: 24px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-warning {
            background-color: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background-color: #d97706;
        }

        .btn-danger {
            background-color: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 16px;
        }

        th {
            background-color: #f3f4f6;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #4b5563;
            border-bottom: 2px solid #e5e7eb;
        }

        td {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #f9fafb;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        /* Status styling */
        .status {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
        }

        .status::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            margin-right: 6px;
        }

        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-active::before {
            background-color: #22c55e;
        }

        .status-expired {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-expired::before {
            background-color: #ef4444;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 16px;
                border-radius: 0;
                box-shadow: none;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            td, th {
                padding: 12px;
            }

            .btn {
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Subscription Management</h2>
        <div class="header-actions">
            <a href="add_subscription_plan.php" class="btn btn-primary">Add New Plan</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Plan</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['plan_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                        <td>
                            <span class="status status-<?php echo strtolower($row['status']); ?>">
                                <?php echo htmlspecialchars($row['status']); ?>
                            </span>
                        </td>
                        <td class="actions">
                            <a href="edit_subscription.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="cancel_subscription.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Cancel</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>