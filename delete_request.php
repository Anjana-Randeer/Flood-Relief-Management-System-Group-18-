<?php
session_start();
include 'connection.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $id = (int)$_GET['id'];
    $user_id = (int)$_SESSION['user_id'];

    
    $sql = "DELETE FROM relief_requests WHERE request_id = $id AND user_id = $user_id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Request deleted successfully.'); window.location.href='dashboard_user.php';</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    header("Location: dashboard_user.php");
    exit();
}
?>
