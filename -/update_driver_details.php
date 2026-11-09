<?php
session_start();
include '../php/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $contact = $_POST['driverContact'];
    $plate = $_POST['driverPlate'];

    $sql = "UPDATE tbl_users SET contact = '$contact', plate = '$plate', updated_at = NOW() WHERE id = '$user_id'";
    if (mysqli_query($conn, $sql)) {
        
              $_SESSION['contact'] = $contact;
                 $_SESSION['plate'] = $plate;
        echo json_encode(['success' => true, 'message' => 'Profile details updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed.']);
    }
}
?>
