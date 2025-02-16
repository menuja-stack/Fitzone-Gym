<?php
session_start();

require_once 'config.php';

try {
    // Use the $pdo variable for the PDO connection
    $sql = "SELECT * FROM plans"; 
    $stmt = $pdo->query($sql); // Prepare the statement and execute
    
    if (!$stmt) {
        throw new Exception("Error fetching plans.");
    }
} catch (Exception $e) {
    $error_message = $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Workout Plans</title>
    <link rel="stylesheet" href="style6.css">
</head>
<body>
    <div class="container mt-5">
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <h2 class="mb-4">Choose Your Workout Plan</h2>
        <div class="row">
            <?php if (isset($stmt) && $stmt->rowCount() > 0): ?>
                <?php while($plan = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($plan['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($plan['description']); ?></p>
                                <p class="card-text">Rs.<?php echo number_format($plan['price_per_month'], 2); ?> / month</p>
                                <a href="subscribe.php?plan_id=<?php echo $plan['id']; ?>" class="btn btn-primary">Subscribe</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-info">No plans are currently available.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>


