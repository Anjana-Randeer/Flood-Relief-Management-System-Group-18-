<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (full_name, email, password, role) VALUES ('$full_name', '$email', '$password', 'user')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Account created successfully!'); window.location.href='login.html';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
