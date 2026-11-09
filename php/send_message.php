<?php
session_start();
include 'conn.php';

$driver_id = isset($_POST['driver_id']) ? intval($_POST['driver_id']) : 0;
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : (isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0);
$book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (empty($message)) {
    echo json_encode(['status' => 'error', 'message' => 'Empty message']);
    exit;
}

if ($book_id <= 0 && ($user_id > 0 || $driver_id > 0)) {
    $searchId = $user_id > 0 ? $user_id : $driver_id;
    $sql = "SELECT id FROM temp_ride_bookings WHERE user_id = $searchId OR driver_id = $searchId ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $book_id = intval($row['id']);
    } else {
        $book_id = 1;
    }
}

$stmt = $conn->prepare("INSERT INTO tbl_messages (conversation_id, sender_id, receiver_id, message, timestamp, status) VALUES (?, ?, ?, ?, ?, 'sent')");
$stmt->bind_param("iiiss", $book_id, $user_id, $driver_id, $message, $ct);

if ($stmt->execute()) {
    echo "Message sent!";
} else {
    echo "Error: " . $conn->error;
}
$stmt->close();
$conn->close();
?>
