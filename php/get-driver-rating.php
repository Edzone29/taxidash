<?php
require 'conn.php';

header('Content-Type: application/json');

$driverId = isset($_GET['driver_id']) ? intval($_GET['driver_id']) : 0;

if ($driverId <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid driver ID']);
    exit;
}

// Get average rating and count
$stmt = $conn->prepare("SELECT COUNT(*) AS total_reviews, COALESCE(AVG(rating), 5.0) AS avg_rating FROM tbl_ratings WHERE driver_id = ?");
$stmt->bind_param("i", $driverId);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

$avgRating = round(floatval($res['avg_rating']), 1);
$totalReviews = intval($res['total_reviews']);

// Also fetch latest 5 reviews
$revStmt = $conn->prepare("SELECT r.rating, r.feedback, r.created_at, u.firstname, u.lastname FROM tbl_ratings r JOIN tbl_users u ON r.user_id = u.id WHERE r.driver_id = ? ORDER BY r.id DESC LIMIT 5");
$revStmt->bind_param("i", $driverId);
$revStmt->execute();
$reviews = $revStmt->get_result()->fetch_all(MYSQLI_ASSOC);

echo json_encode([
    'status' => 'success',
    'avg_rating' => $avgRating,
    'total_reviews' => $totalReviews,
    'recent_reviews' => $reviews
]);

$stmt->close();
$revStmt->close();
?>