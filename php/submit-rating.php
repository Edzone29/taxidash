<?php
session_start();
require 'conn.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId    = intval($_SESSION['user_id']);
    $bookingId = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : 0;
    $driverId  = isset($_POST['driver_id']) ? intval($_POST['driver_id']) : 0;
    $rating    = isset($_POST['rating']) ? intval($_POST['rating']) : 5;
    $feedback  = isset($_POST['feedback']) ? trim($_POST['feedback']) : '';

    if ($rating < 1 || $rating > 5) {
        $rating = 5;
    }

    // Check if rating already exists for this booking
    $checkStmt = $conn->prepare("SELECT id FROM tbl_ratings WHERE booking_id = ? AND user_id = ?");
    $checkStmt->bind_param("ii", $bookingId, $userId);
    $checkStmt->execute();
    $existing = $checkStmt->get_result();

    if ($existing->num_rows > 0) {
        // Update existing rating
        $update = $conn->prepare("UPDATE tbl_ratings SET rating = ?, feedback = ? WHERE booking_id = ? AND user_id = ?");
        $update->bind_param("isii", $rating, $feedback, $bookingId, $userId);
        $update->execute();
        $update->close();
        echo json_encode(['status' => 'success', 'message' => 'Rating updated! Thank you for your feedback.']);
    } else {
        // Insert new rating
        $insert = $conn->prepare("INSERT INTO tbl_ratings (booking_id, user_id, driver_id, rating, feedback) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("iiiis", $bookingId, $userId, $driverId, $rating, $feedback);
        if ($insert->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Thank you for rating your driver!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save rating: ' . $conn->error]);
        }
        $insert->close();
    }
    $checkStmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>