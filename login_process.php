<?php
session_start();
include 'connection.php';

$input_user = $_POST['full_name'];
$input_pass = $_POST['password'];


if ($input_user === 'Admin' && $input_pass === 'admin123') {
    $_SESSION['user_id'] = 0;
    $_SESSION['full_name'] = 'Admin';
    $_SESSION['role'] = 'admin';

    header("Location: dashboard_admin.php");
    exit();
}

$sql = "SELECT * FROM users WHERE full_name = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Database Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $input_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($users = mysqli_fetch_assoc($result)) {
    
    if ($input_pass === $users['password'] || password_verify($input_pass, $users['password'])) {
        $_SESSION['user_id'] = $users['user_id'];
        $_SESSION['full_name'] = $users['full_name'];
        $_SESSION['role'] = $users['role'];

        if ($users['role'] === 'admin') {
            header("Location: dashboard_admin.php");
        } else {
            header("Location: dashboard_user.php");
        }
        exit();
    }
}


echo "<script>alert('Invalid full name or password.'); window.location.href='login.html';</script>";
?>
