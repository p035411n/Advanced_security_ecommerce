<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow">
  <title>Payment - ShopEase</title>
  <link rel="stylesheet" href="shop.css" />
  <link rel="stylesheet" href="payment.css" />
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

  <section id="payment">
    <h2>Payment Authentication</h2>

    <form id="payment-form" action="payment_process.php" method="post">
      <input type="hidden" name="face_data" id="face_data">

      <!-- Payment Method Selection -->
      <label>
        <input type="radio" name="payment-method" value="credit-card" checked />
        Credit/Debit Card
      </label>
      <div class="payment-details card-details">
        <input type="text" id="card-number" name="card-number" placeholder="Card Number" required />
        <input type="text" id="card-holder" name="card-holder" placeholder="Card Holder Name" required />
        <input type="text" id="expiry-date" name="expiry-date" placeholder="Expiry Date (MM/YY)" required />
        <input type="text" id="cvv" name="cvv" placeholder="CVV" required />
        <input type="text" id="amount" name="amount" placeholder="Amount ($)" required />
      </div>

      <!-- PayPal Option -->
      <label>
        <input type="radio" name="payment-method" value="paypal" />
        PayPal
      </label>
      <div class="payment-details paypal-details" style="display: none">
        <input type="text" id="paypal-name" name="paypal-name" placeholder="Full Name" />
        <input type="email" id="paypal-email" name="paypal-email" placeholder="Email Address" />
        <input type="text" id="paypal-amount" name="paypal-amount" placeholder="Amount ($)" />
      </div>

      <!-- Cash on Delivery (COD) Option -->
      <label>
        <input type="radio" name="payment-method" value="cod" />
        Cash on Delivery (COD)
      </label>
      <div class="payment-details cod-details" style="display: none">
        <input type="text" id="cod-amount" name="cod-amount" placeholder="Amount ($)" />
      </div>

      <div id="face-verification">
        <h3>Face Verification</h3>
        <video id="video" autoplay></video>
        <canvas id="canvas" style="display: none;"></canvas>
        <p id="face-status">Please wait for face recognition.</p>
      </div>

      <button type="button" id="pay-btn">Pay Now</button>
      <p id="payment-status"></p>
    </form>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
  <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image"></script>

  <script>
    let model, maxPredictions;
    let predictionPassed = false;
    const URL = "./model"; // path to model files

    // Load the model
    async function loadModel() {
      const modelURL = URL + "/model.json";
      const metadataURL = URL + "/metadata.json";
      model = await tmImage.load(modelURL, metadataURL);
      maxPredictions = model.getTotalClasses();
      console.log("Model loaded successfully");
    }

    loadModel();

    document.addEventListener("DOMContentLoaded", function () {
      const video = document.getElementById("video");
      const canvas = document.getElementById("canvas");
      const context = canvas.getContext("2d");
      const payBtn = document.getElementById("pay-btn");
      const faceStatus = document.getElementById("face-status");
      const paymentStatus = document.getElementById("payment-status");
      const faceDataInput = document.getElementById("face_data");

      // Set up webcam access
      navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
          video.srcObject = stream;
        })
        .catch((err) => {
          alert("Please allow access to your camera.");
        });

      // Trigger face detection when "Pay Now" is clicked
      payBtn.addEventListener("click", async function () {
        faceStatus.style.color = "orange";
        faceStatus.innerText = "Recognizing face, please wait...";

        // Show webcam stream
        const canvasWidth = video.videoWidth;
        const canvasHeight = video.videoHeight;
        canvas.width = canvasWidth;
        canvas.height = canvasHeight;

        // Draw the current frame from the video stream
        context.drawImage(video, 0, 0, canvasWidth, canvasHeight);

        // Predict face using the model
        const prediction = await model.predict(canvas);

        const bestMatch = prediction.reduce((prev, current) =>
          (prev.probability > current.probability) ? prev : current
        );

        if (bestMatch.probability > 0.85) {
          predictionPassed = true;
          faceStatus.style.color = "green";
          faceStatus.innerText = `✅ Face Verified: ${bestMatch.className}`;
          faceDataInput.value = canvas.toDataURL("image/png"); // Save face data
          paymentStatus.style.color = "green";
          paymentStatus.innerText = "Payment Successful!";
        } else {
          predictionPassed = false;
          faceStatus.style.color = "red";
          faceStatus.innerText = "❌ Face not recognized. Please try again.";
          paymentStatus.style.color = "red";
          paymentStatus.innerText = "Face Verification Failed!";
        }
      });
    });
  </script>
</body>
</html>