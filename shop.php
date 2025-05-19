<?php
include 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow">
  <title>Shop - ShopEase</title>
  <link rel="stylesheet" href="shop.css" />

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

  <!-- Shop Section -->
  <section id="shop">
    <h2>Our Products</h2>

    <!-- Electronics & Gadgets -->
    <div class="category">
      <h3>Electronics & Gadgets</h3>
      <div class="product-container">
        <div class="product-card">
          <img src="images/smartphone-remove.png" alt="Smartphone" />
          <h3>Smartphone</h3>
          <p>$699.00</p>
          <button
            onclick="window.location.href='payment.php'"
            class="buy-now" data-name="smartphone" data-price="699" data-image="images/smartphone-remove.png">
            BUY NOW
          </button>
        </div>
        <div class="product-card">
          <img src="images/airpods-remove.png" alt="Wireless Earbuds" />
          <h3>Wireless Earbuds</h3>
          <p>$129.00</p>
          <button
            onclick="window.location.href='payment.php'"
            class="buy-now">
            BUY NOW
          </button>
        </div>
      </div>
    </div>

    <!-- Fashion & Apparel -->
    <div class="category">
      <h3>Fashion & Apparel</h3>
      <div class="product-container">
        <div class="product-card">
          <img src="images/jacket-remove.png" alt="Designer Jacket" />
          <h3>Designer Jacket</h3>
          <p>$120.00</p>
          <button
            onclick="window.location.href='payment.php'"
            class="buy-now">
            BUY NOW
          </button>
        </div>
        <div class="product-card">
          <img src="images/handbag-remove.png" alt="Luxury Handbag" />
          <h3>Luxury Handbag</h3>
          <p>$250.00</p>
          <button
            onclick="window.location.href='payment.php'"
            class="buy-now">
            BUY NOW
          </button>
        </div>
      </div>
    </div>

    <!-- Beauty & Skincare -->
    <div class="category">
      <h3>Beauty & Skincare</h3>
      <div class="product-container">
        <div class="product-card">
          <img
            src="images/skin-care-products-removebg.png"
            alt="Face Serum" />
          <h3>Face Serum</h3>
          <p>$35.00</p>
          <button
            onclick="window.location.href='payment.php'"
            class="buy-now">
            BUY NOW
          </button>
        </div>
        <div class="product-card">
          <img src="images/lipstick-remove.png" alt="Matte Lipstick" />
          <h3>Matte Lipstick</h3>
          <p>$20.00</p>
          <button
            onclick="window.location.href='payment.php'"
            class="buy-now">
            BUY NOW
          </button>
        </div>
      </div>
    </div>

    <!-- Home & Kitchen -->
    <div class="category">
      <h3>Home & Kitchen</h3>
      <div class="product-container">
        <div class="product-card">
          <img src="images/deep-fryer-remove.png" alt="Air Fryer" />
          <h3>Air Fryer</h3>
          <p>$99.00</p>
          <button
            onclick="window.location.href='payment.php'"
            class="buy-now">
            BUY NOW
          </button>
        </div>
        <div class="product-card">
          <img src="images/cookware-remove.png" alt="Cookware Set" />
          <h3>Cookware Set</h3>
          <p>$150.00</p>
          <button
            onclick="window.location.href='payment.php'"
            class="buy-now">
            BUY NOW
          </button>
        </div>
      </div>
    </div>

    <!-- Fitness & Sports -->
    <div class="category">
      <h3>Fitness & Sports</h3>
      <div class="product-container">
        <div class="product-card">
          <img src="images/yoga-mat-removebg.png" alt="Yoga Mat" />
          <h3>Yoga Mat</h3>
          <p>$30.00</p>
          <button
            onclick="window.location.href='payment.php'"
            class="buy-now">
            BUY NOW
          </button>
        </div>
        <div class="product-card">
          <img src="images/dumbbells-remove.png" alt="Dumbbells Set" />
          <h3>Dumbbells Set</h3>
          <p>$70.00</p>
          <button
            onclick="window.location.href='payment.php'"
            class="buy-now">
            BUY NOW
          </button>
        </div>
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
          <li><a href="signup.phps">Signup</a></li>
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