<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


$user_result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id");
$user = mysqli_fetch_assoc($user_result);

if (!$user) { die("User not found."); }


$req_result = mysqli_query($conn, "SELECT COUNT(*) as total, MAX(district) as last_district, MAX(relief_type) as main_type FROM relief_requests WHERE user_id = $user_id");
$activity = mysqli_fetch_assoc($req_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar">
    <span>Flood Relief System (Admin)</span>
    <a href="logout.php">Logout</a>
</nav>
<div class="container">
    <h2>User Detailed Information</h2>
    <hr>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
        <div class="card" style="text-align: left;">
            <h4 style="border-bottom: 2px solid #004085; padding-bottom: 5px;">Account Details</h4>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
            <p><strong>Registered Date:</strong> <?php echo date('Y-m-d', strtotime($user['created_at'])); ?></p>
        </div>
        <div class="card" style="text-align: left;">
            <h4 style="border-bottom: 2px solid #004085; padding-bottom: 5px;">Relief Activity</h4>
            <p><strong>Total Requests Filed:</strong> <?php echo $activity['total']; ?></p>
            <p><strong>Most Recent District:</strong> <?php echo htmlspecialchars($activity['last_district'] ?? 'N/A'); ?></p>
            <p><strong>Primary Relief Type:</strong> <?php echo htmlspecialchars($activity['main_type'] ?? 'N/A'); ?></p>
        </div>
    </div>
    <div style="margin-top: 20px; text-align: center;">
        <a href="dashboard_admin.php" class="btn btn-primary">Back to User List</a>
    </div>
</div>
</body>
</html>
