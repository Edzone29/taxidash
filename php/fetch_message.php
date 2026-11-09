<?php
include 'conn.php';

$driver_id = isset($_POST['driver_id']) ? intval($_POST['driver_id']) : 0;
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;

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

$query = "SELECT * FROM tbl_messages 
          WHERE (conversation_id = $book_id OR conversation_id = 0) 
            AND ((sender_id = $user_id AND receiver_id = $driver_id) OR (sender_id = $driver_id AND receiver_id = $user_id)) 
          ORDER BY timestamp ASC";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $isMe = ($row['sender_id'] == $user_id);
        $messageClass = $isMe ? 'text-end' : 'text-start';
        $timestamp = date('g:i A', strtotime($row['timestamp']));
        $sender = $isMe ? 'You' : 'Driver';
        $bubbleBg = $isMe ? 'background: linear-gradient(135deg, #1e3c72, #3bafda); color: #fff;' : 'background: #e2e8f0; color: #1e293b;';
        $safeMsg = htmlspecialchars($row['message']);

        echo "
        <div class='mb-2 {$messageClass}'>
            <div class='d-inline-block px-3 py-2 rounded-3 text-break' style='max-width: 80%; {$bubbleBg} font-size: 0.92rem; text-align: left;'>
                {$safeMsg}
            </div>
            <div class='text-muted' style='font-size: 0.72rem; margin-top: 2px;'>
                {$sender} &bull; {$timestamp}
            </div>
        </div>";
    }
} else {
    echo "
    <div class='text-center text-muted py-4'>
        <i class='fas fa-comments fa-2x mb-2 text-muted opacity-50'></i>
        <p class='small mb-0'>No messages yet. Start the conversation!</p>
    </div>";
}
?>
