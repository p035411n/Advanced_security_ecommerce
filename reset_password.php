<?php
session_start();
include 'db_connection.php';
date_default_timezone_set('Asia/Karachi'); // Set the correct timezone

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate token input
    if (!isset($_POST['reset_token']) || empty($_POST['reset_token'])) {
        die("<script>alert('Error: Missing token. Please try resetting your password again.'); window.location.href='forget_password.php';</script>");
    }

    // Validate password input
    if (!isset($_POST['pasword']) || empty($_POST['pasword'])) {
        die("<script>alert('Error: Missing password. Please enter a new password.'); window.location.href='reset_password.php?reset_token=" . $_POST['reset_token'] . "';</script>");
    }

    $token = mysqli_real_escape_string($conn, $_POST['reset_token']);
    $new_password = password_hash($_POST['pasword'], PASSWORD_BCRYPT);

    // Retrieve user details using the token
    $sql = "SELECT user_id FROM users WHERE reset_token='$token' AND reset_token_expiry > NOW() LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Token is valid, update password
        $user = mysqli_fetch_assoc($result);
        
        // Ensure 'id' column exists
        if (!isset($user['user_id'])) {
            die("<script>alert('Error: User ID not found. Please request a new password reset.'); window.location.href='forget_password.php';</script>");
        }
        
        $user_id = $user['user_id']; // Get user ID
        
        // Update password and clear token
        $update_sql = "UPDATE users SET pasword='$new_password', reset_token=NULL, reset_token_expiry=NULL WHERE user_id='$user_id'";
        
        if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Password reset successful. You can now log in.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Database error. Try again later.');</script>";
        }
    } else {
        echo "<script>alert('Invalid or expired token. Please request a new password reset.'); window.location.href='forget_password.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="styles.css">
    <script>
  document.addEventListener("keydown", function(event) {
    if (
      event.key === "F12" ||
      (event.ctrlKey && event.shiftKey && event.key === "I") ||
      (event.ctrlKey && event.key === "U")
    ) {
      event.preventDefault(); // Blocks DevTools
      alert("Inspecting elements is disabled!");
    }
  });
</script>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form action="reset_password.php" method="POST">
            <!-- Ensure reset_token is correctly passed -->
            <input type="hidden" name="reset_token" value="<?php echo isset($_GET['reset_token']) ? htmlspecialchars($_GET['reset_token']) : ''; ?>">
            <label for="password">New Password:</label>
            <input type="password" name="pasword" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
<script>
    document.addEventListener("contextmenu", function(event) {
      event.preventDefault(); // Disables right-click
      alert("Right-click is disabled on this page!");
    });
  </script>
</html>
