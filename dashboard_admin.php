<?php
session_start();
include 'connection.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}


if (isset($_GET['delete_user'])) {
    $del_id = (int)$_GET['delete_user'];
    mysqli_query($conn, "DELETE FROM users WHERE user_id = $del_id");
    header("Location: dashboard_admin.php");
    exit();
}


$filter_district = isset($_GET['area']) ? mysqli_real_escape_string($conn, $_GET['area']) : '';
$filter_type = isset($_GET['type']) ? mysqli_real_escape_string($conn, $_GET['type']) : '';


$req_sql = "SELECT rr.*, u.full_name FROM relief_requests rr JOIN users u ON rr.user_id = u.user_id WHERE 1=1";
if ($filter_district) $req_sql .= " AND rr.district = '$filter_district'";
if ($filter_type)     $req_sql .= " AND rr.relief_type = '$filter_type'";
$req_sql .= " ORDER BY rr.created_at DESC";
$req_result = mysqli_query($conn, $req_sql);


$total_users   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM users WHERE role='user'"))['c'];
$high_severity = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM relief_requests WHERE flood_severity='High'"))['c'];
$food_requests = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM relief_requests WHERE relief_type='Food'"))['c'];


$users_result = mysqli_query($conn, "SELECT user_id, full_name, role FROM users WHERE role = 'user'");


$districts_result = mysqli_query($conn, "SELECT DISTINCT district FROM relief_requests ORDER BY district");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar">
    <span>Flood Relief System | Admin Dashboard</span>
    <a href="logout.php">Logout</a>
</nav>
<div class="container">
    <h3>System Summary Report</h3>
    <div class="stats-grid">
        <div class="card">
            <h4>Total Users</h4>
            <p style="font-size:2rem; font-weight:bold; color:#004085;"><?php echo $total_users; ?></p>
        </div>
        <div class="card">
            <h4>High Severity</h4>
            <p style="font-size:2rem; font-weight:bold; color:#dc3545;"><?php echo $high_severity; ?></p>
        </div>
        <div class="card">
            <h4>Food Requests</h4>
            <p style="font-size:2rem; font-weight:bold; color:#28a745;"><?php echo $food_requests; ?></p>
        </div>
    </div>

    <h3>Filter Relief Requests</h3>
    <form method="GET" style="display: flex; gap: 10px; margin-bottom: 20px;">
        <select name="area">
            <option value="">All Districts</option>
            <?php while($d = mysqli_fetch_assoc($districts_result)): ?>
                <option value="<?php echo $d['district']; ?>" <?php if($filter_district == $d['district']) echo 'selected'; ?>>
                    <?php echo $d['district']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <select name="type">
            <option value="">All Relief Types</option>
            <?php foreach(['Food','Water','Medicine','Shelter'] as $t): ?>
                <option value="<?php echo $t; ?>" <?php if($filter_type == $t) echo 'selected'; ?>><?php echo $t; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="dashboard_admin.php" class="btn btn-danger">Clear</a>
    </form>

    <h3>Relief Requests</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Type</th>
                    <th>District</th>
                    <th>Severity</th>
                    <th>Contact</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($req_result) > 0):
                    while($row = mysqli_fetch_assoc($req_result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['relief_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['district']); ?></td>
                    <td><?php echo htmlspecialchars($row['flood_severity']); ?></td>
                    <td><?php echo htmlspecialchars($row['contact_person']); ?></td>
                    <td><?php echo date('Y-m-d', strtotime($row['created_at'])); ?></td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="6" style="text-align:center;">No requests found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <h3 style="margin-top:30px;">All Registered Users</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Action</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($users_result) > 0):
                    while($row = mysqli_fetch_assoc($users_result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                    <td>
                        <a href="dashboard_admin.php?delete_user=<?php echo $row['user_id']; ?>"
                           class="btn btn-danger"
                           onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                    <td>
                        <button class="btn btn-primary"
                                onclick="viewUserDetails(<?php echo $row['user_id']; ?>)">View User</button>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="4" style="text-align:center;">No registered users found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
