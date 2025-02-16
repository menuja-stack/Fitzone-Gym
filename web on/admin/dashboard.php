<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active" onclick="showSection('manage-users')">Manage Users</a>
                    <a href="#" class="list-group-item list-group-item-action" onclick="showSection('manage-admins')">Manage Admins</a>
                    <a href="#" class="list-group-item list-group-item-action" onclick="showSection('user-feedback')">User Feedback</a>
                    <a href="#" class="list-group-item list-group-item-action" onclick="showSection('workout-plans')">Workout Plans</a>
                </div>
            </div>
            <div class="col-md-9">
                <!-- Manage Users Section -->
                <div id="manage-users" class="section">
                    <h3>Manage Users</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM users WHERE role = 'user'");
                            while ($row = $stmt->fetch()) {
                                echo "<tr>";
                                echo "<td>{$row['username']}</td>";
                                echo "<td>{$row['email']}</td>";
                                echo "<td>
                                        <button class='btn btn-sm btn-danger' onclick='removeUser({$row['id']})'>Remove</button>
                                    </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- User Feedback Section -->
                <div id="user-feedback" class="section" style="display: none;">
                    <h3>User Feedback</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query("SELECT f.*, u.username FROM feedback f JOIN users u ON f.user_id = u.id");
                            while ($row = $stmt->fetch()) {
                                echo "<tr>";
                                echo "<td>{$row['username']}</td>";
                                echo "<td>{$row['comment']}</td>";
                                echo "<td>{$row['created_at']}</td>";
                                echo "<td>
                                        <button class='btn btn-sm btn-danger' onclick='removeFeedback({$row['id']})'>Remove</button>
                                    </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
        }

        function removeUser(userId) {
            if (confirm('Are you sure you want to remove this user?')) {
                window.location.href = 'remove_user.php?id=' + userId;
            }
        }

        function removeFeedback(feedbackId) {
            if (confirm('Are you sure you want to remove this feedback?')) {
                window.location.href = 'remove_feedback.php?id=' + feedbackId;
            }
        }
    </script>
</body>
</html>
