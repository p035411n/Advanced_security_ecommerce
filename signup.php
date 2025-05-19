<?php
session_start();
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $face_data = mysqli_real_escape_string($conn, $_POST['face_data']);
    $created_at = date("Y-m-d H:i:s");

    // Check if the email is already in use
    $email_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $email_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        echo "<script>alert('Email already exists. Please try with a different email.');</script>";
    } elseif ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $query = "INSERT INTO users (full_name, email, password, confirm_password, created_at, face_data) 
                  VALUES ('$full_name', '$email', '$hashed_password', '$confirm_password', '$created_at', '$face_data')";

        if (mysqli_query($conn, $query)) {
            $_SESSION['user_id'] = mysqli_insert_id($conn);  // Store user id in session
            echo "<script>alert('Signup successful! Please log in.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow">
  <title>Signup - ShopEase</title>
  <link rel="stylesheet" href="signup.css" />
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

  <section class="signup-container">
    <h2>Create a New Account</h2>
    <form action="signup.php" method="POST" class="signup-form" onsubmit="return captureFaceData();">
      <label for="name">Full Name:</label>
      <input type="text" id="name" name="full_name" required />

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required />

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required />

      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" name="confirm_password" required />

      <!-- Face Recognition -->
      <div class="face-recognition">
        <video id="video" width="320" height="240" autoplay></video>
        <button type="button" onclick="takeSnapshot()">Capture Face</button>
        <canvas id="canvas" style="display: none;"></canvas>
        <input type="hidden" name="face_data" id="face_data" />
      </div>

      <div class="g-recaptcha" data-sitekey="6LdYB-oqAAAAABi-kMCB00iCOKtU937mDA_1YU7P"></div>

      <button type="submit" class="signup-btn">Signup</button>
    </form>
    <div class="signup-links">
      <p>Already have an account? <a href="login.php">Login here</a></p>
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

  <script>
    function captureFaceData() {
      let faceData = document.getElementById('face_data').value;
      if (!faceData) {
        alert('Please capture your face before signing up.');
        return false;
      }
      return true;
    }

    function takeSnapshot() {
      let video = document.getElementById('video');
      let canvas = document.getElementById('canvas');
      let context = canvas.getContext('2d');

      // Ensure canvas size matches video feed
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;

      // Capture image from video to canvas
      context.drawImage(video, 0, 0, canvas.width, canvas.height);

      // Convert canvas image to Base64 format
      let faceData = canvas.toDataURL('image/png');

      // Assign captured data to hidden input field
      document.getElementById('face_data').value = faceData;

      alert('Face captured successfully!');
    }

    // Request camera access
    navigator.mediaDevices.getUserMedia({
        video: true
      })
      .then(stream => {
        document.getElementById('video').srcObject = stream;
      })
      .catch(error => {
        alert('Camera access is required for face recognition.');
      });
  </script>
</body>

</html>
