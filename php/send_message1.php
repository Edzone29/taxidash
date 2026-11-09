<?php
include 'conn.php';
session_start();

$book_id = $_POST['ticket_id'];
$driver_id = $_SESSION['user_id'];
$userID = $_POST['userID'];


$message = mysqli_real_escape_string($conn, $_POST['message']);

$query = "
    INSERT INTO tbl_concern (conversation_id, sender_id, receiver_id, message, timestamp) 
    VALUES ('$book_id', '$driver_id', '$userID',  '$message', '$ct')";

if (mysqli_query($conn, $query)) {
    echo "Message sent!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
