<?php
date_default_timezone_set('Asia/Manila');

$servername = "localhost";
$username = "root"; // XAMPP default username
$password = ""; // XAMPP default password (empty)
$dbname = "taxidash"; // Local database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Get the current timestamp
$ct = date('Y-m-d H:i:s');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
