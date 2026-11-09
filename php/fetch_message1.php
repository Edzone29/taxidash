<?php
include 'conn.php';
session_start();

// Now you can use session variables
// $user_id = $_SESSION['user_id'] ;
$user_id = $_POST['userID'] ;
$driver_id = $_POST['ticket_id'];





$query = "SELECT * FROM tbl_concern WHERE conversation_id=$driver_id   ORDER BY timestamp ASC";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Determine the correct Bootstrap class for sender/receiver alignment
        $messageClass = ($row['sender_id'] != $user_id) ? 'text-end' : 'text-start';
        
        // Format timestamp
        $timestamp = date('g:i A', strtotime($row['timestamp']));

        // Determine the sender text
        $sender = ($row['sender_id'] != $user_id) ? 'Admin' : 'Client';
        
        // Set background color based on sender (user or driver)
        $bgColor = ($row['sender_id'] != $user_id) ?   'bg-info text-white' : 'bg-light text-dark'; // User gets info (blue), Driver gets light (gray)
        
        echo "
        <div class='mb-3 {$messageClass}'>
            <div class='d-inline-block p-2 {$bgColor} rounded-pill' style='max-width: 75%; word-wrap: break-word;'>
                {$row['message']}
            </div>
            <small class='text-muted'>{$sender} • {$timestamp}</small>
        </div>";
    }
} else {
    echo "<p>No messages yet.</p>";
}
?>
