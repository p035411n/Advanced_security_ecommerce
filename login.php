<?php
session_start();
include 'db_connection.php';

// Security Headers to Block Bots
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");
header("X-Robots-Tag: noindex, nofollow");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);

  // Google reCAPTCHA verification
  $recaptcha_secret = "6LdYB-oqAAAAAPY-G8XCZOPVPP6J0tycxIXn2beD";
  $recaptcha_response = $_POST["g-recaptcha-response"];
  $verify_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");
  $response_data = json_decode($verify_response);

  if (!$response_data->success) {
    echo "<script>alert('reCAPTCHA verification failed!');</script>";
    exit();
  }

  // Check Admin Login
  $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $admin_result = $stmt->get_result();

  if ($admin_result && $admin_result->num_rows > 0) {
    $admin = $admin_result->fetch_assoc();

    if (password_verify($password, $admin['password'])) {
      $_SESSION["admin_id"] = $admin["admin_id"];
      $_SESSION["admin_name"] = $admin["full_name"];
      $_SESSION["admin_logged_in"] = true;

      echo "<script>alert('Admin login successful! Redirecting...');</script>";
      echo "<script>window.location.href='adminside/admin_dashboard.php';</script>";
      exit();
    }
  }

  // Check User Login (NEW PREPARE)
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $user_result = $stmt->get_result();

  if ($user_result && $user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
      $_SESSION["user_id"] = $user["user_id"];
      $_SESSION["user_name"] = $user["full_name"];
      $_SESSION["user_logged_in"] = true;

      echo "<script>alert('Login successful! Redirecting to shop...');</script>";
      echo "<script>window.location.href='shop.php';</script>";
      exit();
    }
  }

  // If login failed
  echo "<script>alert('Invalid email or password.');</script>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow">
  <title>Login - ShopEase</title>
  <link rel="stylesheet" href="login.css" />
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  
</head>

<body>
  <header>
    <nav>
      <div class="logo">Shop<span style="color: #ffcc00">Ease</span></div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="shop.php">Shop</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <section class="login-container">
    <h2>Login to Your Account</h2>
    <form action="login.php" method="POST" class="login-form">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required />

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required />

      <!-- Google reCAPTCHA -->
      <div class="g-recaptcha" data-sitekey="6LdYB-oqAAAAABi-kMCB00iCOKtU937mDA_1YU7P"></div>

      <button type="submit" class="login-btn">Login</button>
    </form>
    <div class="login-links">
      <a href="forget_password.php">Forgot Password?</a>
      <p>Don't have an account? <a href="signup.php">Signup here</a></p>
    </div>
  </section>

  <footer>
    <div class="footer-columns">
      <div class="footer-column">
        <h3>ShopEase</h3>
        <p>Your trusted online store for the best products.</p>
      </div>
      <div class="footer-column">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="shop.php">Shop</a></li>
          <li><a href="login.php">Login</a></li>
          <li><a href="signup.php">Signup</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Contact Us</h3>
        <p>Email: support@shopease.com</p>
        <p>Phone: +123 456 7890</p>
      </div>
    </div>
    <p>&copy; 2025 ShopEase. All Rights Reserved.</p>
  </footer>
</body>



</html>
