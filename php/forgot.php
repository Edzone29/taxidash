<?php
session_start();
include 'conn.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; // Get the email from the form
    
    // Sanitize email input (prevent SQL injection)
    $email = mysqli_real_escape_string($conn, $email);

    // Check if email exists in the database
    $sql = "SELECT * FROM tbl_users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Email exists, send password reset link
        $resetLink = "https://taxidash.online/change?email=" . $email;
        
        // Prepare the email
  $subject = "Change Your Password";

// HTML email content
$message = "
<html>
<head>
    <title>Change Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .header h1 {
            color: #0066cc;
        }
        .content {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            text-align: center;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
        }
        .cta-button {
            display: inline-block;
            background-color: #0066cc;
            color: #ffffff;
            padding: 15px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 16px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class='email-container'>
        <div class='header'>
            <h1>Reset Your Password</h1>
        </div>
        <div class='content'>
            <p>Hi there,</p>
            <p>We received a request to reset the password for your account. To proceed, simply click the button below:</p>
            <a href='" . $resetLink . "' class='cta-button'>Reset Your Password</a>
            <p>If you did not request a password reset, please ignore this email. Your password will not be changed.</p>
        </div>
        <div class='footer'>
            <p>Thank you for using our service!</p>
        </div>
    </div>
</body>
</html>
";

// Set content-type for HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
$headers .= "From: no-reply@taxidash.online" . "\r\n";

        
        // Send the email
        if (mail($email, $subject, $message, $headers)) {
            echo json_encode(['status' => 'success', 'message' => 'A link to reset your password has been sent to your email.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send the password reset email.']);
        }
    } else {
        // Email does not exist
        echo json_encode(['status' => 'error', 'message' => 'Email does not exist.']);
    }
}
?>
