<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'config.php';

// Fetch users
$stmt = $pdo->query("SELECT id, username, email, user_type, created_at FROM users");
$users = $stmt->fetchAll();

// Fetch feedback with usernames
$stmt = $pdo->query("SELECT f.*, u.username FROM feedback f JOIN users u ON f.user_id = u.id ORDER BY f.created_at DESC");
$feedbacks = $stmt->fetchAll();

// Fetch subscriptions
$sql = "SELECT s.*, u.username, p.name 
        FROM subscriptions s 
        JOIN users u ON s.user_id = u.id 
        JOIN plans p ON s.plan_id = p.id 
        ORDER BY s.start_date DESC";
$subscriptions = $pdo->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="style9.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="container">
            <div class="navbar">
                <span class="title">Admin Dashboard</span>
                <a href="logout.php" class="logout">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">
        
        <!-- Add New User Section -->
        <div class="card">
            <h3>Add New Customer</h3>
            <form action="admin_actions.php" method="POST">
                <input type="hidden" name="action" value="add_user">
                <div>
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div>
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" name="is_admin">
                    <span>Make this user an admin</span>
                </div>
                <button type="submit">Add User</button>
            </form>
        </div>

        <!-- User Management Section -->
        <div class="card">
            <h3>User Management</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['user_type']); ?></td>
                            <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                            <td class="actions">
                                <form action="admin_actions.php" method="POST" class="inline">
                                    <input type="hidden" name="action" value="toggle_admin">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit">
                                        <?php echo $user['user_type'] == 'admin' ? 'Remove Admin' : 'Make Admin'; ?>
                                    </button>
                                </form>
                                <form action="admin_actions.php" method="POST" class="inline">
                                    <input type="hidden" name="action" value="delete_user"><br>
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="delete" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- User Feedback Section -->
        <div class="card feedback">
            <h3>Customer Feedback</h3>
            <?php foreach ($feedbacks as $feedback): ?>
            <div>
                <span class="username"><?php echo htmlspecialchars($feedback['username']); ?></span>
                <span class="date"><?php echo htmlspecialchars($feedback['created_at']); ?></span>
                <p><?php echo htmlspecialchars($feedback['message']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Subscription Management Section -->
        <div class="card subscription">
            <h3>Subscription Management</h3>
            <a href="plans.php" class="btn">Add New Plan</a>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Plan</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subscriptions as $subscription): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($subscription['username'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($subscription['name'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($subscription['start_date'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($subscription['end_months'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($subscription['statues'] ?? 'N/A'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>

