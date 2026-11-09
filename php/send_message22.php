<?php
include 'conn.php';
session_start();

$book_id = $_POST['ticket_id'];
// $driver_id = ;
$userID = $_SESSION['user_id'];


$message = mysqli_real_escape_string($conn, $_POST['message']);

$query = "
    INSERT INTO tbl_messages (conversation_id, sender_id, receiver_id, message, timestamp) 
    VALUES ('$book_id', '$userID', '17', '$message', '$ct')";

if (mysqli_query($conn, $query)) {
    echo "Message sent!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
