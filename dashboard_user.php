<?php
session_start();
include 'connection.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$sql = "SELECT * FROM relief_requests WHERE user_id = $user_id ORDER BY request_id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar">
    <span>Flood Relief System | User Dashboard</span>
    <div>
        <a href="request_form.html">New Request</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>
<div class="container">
    <h3>My Relief Requests</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>District</th>
                    <th>Severity</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0):
                    while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['relief_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['district']); ?></td>
                    <td><?php echo htmlspecialchars($row['flood_severity']); ?></td>
                    <td><?php echo date('Y-m-d', strtotime($row['created_at'])); ?></td>
                    <td>
                        <a href="edit_request.php?id=<?php echo $row['request_id']; ?>" class="btn btn-primary">Edit</a>
                        <a href="delete_request.php?id=<?php echo $row['request_id']; ?>"
                           class="btn btn-danger"
                           onclick="return confirm('Are you sure you want to delete this request?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="5" style="text-align:center;">No requests found. <a href="request_form.html">Submit one now.</a></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
