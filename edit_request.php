<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$id = (int)$_GET['id'];
$user_id = (int)$_SESSION['user_id'];


$query = "SELECT * FROM relief_requests WHERE request_id = $id AND user_id = $user_id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) { die("Request not found or unauthorized access."); }


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contact_person = mysqli_real_escape_string($conn, $_POST['contact_name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $relief_type = mysqli_real_escape_string($conn, $_POST['relief_type']);
    $severity = mysqli_real_escape_string($conn, $_POST['flood_severity']);

    $update_sql = "UPDATE relief_requests SET 
                   contact_person='$contact_person', 
                   address='$address', 
                   relief_type='$relief_type', 
                   flood_severity='$severity' 
                   WHERE request_id=$id AND user_id=$user_id";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Updated successfully!'); window.location.href='dashboard_user.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Request</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar">
    <span>Flood Relief System (User)</span>
    <div>
        <a href="dashboard_user.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>
<div class="container">
    <div class="card">
        <h2>Edit Relief Request</h2>
        <form method="POST">
            <div class="form-group">
                <label>Contact Name</label>
                <input type="text" name="contact_name" value="<?php echo htmlspecialchars($data['contact_person']); ?>" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" required><?php echo htmlspecialchars($data['address']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Relief Type</label>
                <select name="relief_type">
                    <?php foreach(['Food','Water','Medicine','Shelter'] as $t): ?>
                    <option value="<?php echo $t; ?>" <?php if($data['relief_type'] == $t) echo 'selected'; ?>><?php echo $t; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Flood Severity</label>
                <select name="flood_severity">
                    <?php foreach(['Low','Medium','High'] as $s): ?>
                    <option value="<?php echo $s; ?>" <?php if($data['flood_severity'] == $s) echo 'selected'; ?>><?php echo $s; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="dashboard_user.php" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>
</body>
</html>
