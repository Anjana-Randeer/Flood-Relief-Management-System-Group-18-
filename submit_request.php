<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id             = (int)$_SESSION['user_id'];
    $contact_person      = mysqli_real_escape_string($conn, $_POST['contact_name']);
    $contact_number      = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $address             = mysqli_real_escape_string($conn, $_POST['address']);
    $district            = mysqli_real_escape_string($conn, $_POST['district']);
    $div_secretariat     = mysqli_real_escape_string($conn, $_POST['divisional_secretariat']);
    $gn_division         = mysqli_real_escape_string($conn, $_POST['gn_division']);
    $family_members      = (int)$_POST['family_members'];
    $relief_type         = mysqli_real_escape_string($conn, $_POST['relief_type']);
    $flood_severity      = mysqli_real_escape_string($conn, $_POST['flood_severity']);
    $description         = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "INSERT INTO relief_requests 
            (user_id, contact_person, contact_number, address, district, divisional_secretariat, gn_division, family_members, relief_type, flood_severity, description)
            VALUES 
            ($user_id, '$contact_person', '$contact_number', '$address', '$district', '$div_secretariat', '$gn_division', $family_members, '$relief_type', '$flood_severity', '$description')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Your relief request has been submitted successfully!'); window.location.href='dashboard_user.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
