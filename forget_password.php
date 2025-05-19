<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'db_connection.php';
date_default_timezone_set('Asia/Karachi'); // Set your correct timezone

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Generate a secure token
        $token = bin2hex(random_bytes(32)); 
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour")); // Token expires in 1 hour

        // Store the token and expiry in the database
        $update_sql = "UPDATE users SET reset_token='$token', reset_token_expiry='$expiry' WHERE email='$email'";
        if (mysqli_query($conn, $update_sql)) {
            
            // Send the reset password email
            $mail = new PHPMailer(true);

            try {
                // SMTP Configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.mailtrap.io'; // Use Mailtrap for testing
                $mail->SMTPAuth = true;
                $mail->Username = '6823b388270412';
                $mail->Password = '982319664dd138';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 2525;

                // Email details
                $mail->setFrom('noreply@shopease.com', 'shopease');
                $mail->addAddress($email);
                $mail->Subject = "Password Reset Request";
                $mail->Body = "Click the link below to reset your password:\n\n".
                    "http://localhost/e%20commerce/reset_password.php?reset_token=$token\n\n".
                    "This link will expire in 1 hour.";

                $mail->send();
                echo "<script>alert('Password reset email sent! Check your inbox.'); window.location.href='login.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
            }
        } else {
            echo "<script>alert('Database error. Try again later.');</script>";
        }
    } else {
        echo "<script>alert('Email not found. Please enter a registered email.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forget Password</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="forget_password.css">
</head>
<body>
    <div class="container">
        <h2>Forget Password</h2>
        <p>Enter your email to receive a password reset link.</p>
        <form action="forget_password.php" method="POST">
            <label for="email">Email Address:</label>
            <input type="email" name="email" required>
            <button type="submit">Send Reset Link</button>
        </form>
    </div>
</body>
</html>