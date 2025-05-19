<?php
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow">
  <title>Professional E-Commerce Website</title>
  <link rel="stylesheet" href="styles.css" />

</head>

<body>
  <!-- Navigation Bar -->
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

  <!-- Home Section -->
  <section id="home">
    <div class="hero">
      <h1>Welcome to ShopEase</h1>
      <p>Your one-stop shop for everything you need</p>
      <a href="shop.php" class="btn">Shop Now</a>
    </div>
    <div class="home-details">
      <div class="column">
        <h2>About Us</h2>
        <p>
          We offer a wide variety of high-quality products at unbeatable
          prices.
        </p>
      </div>
      <div class="column">
        <h2>Our Mission</h2>
        <p>To provide customers with the best online shopping experience.</p>
      </div>
      <div class="column">
        <h2>Why Choose Us?</h2>
        <p>Fast delivery, secure payments, and 24/7 customer support.</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
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