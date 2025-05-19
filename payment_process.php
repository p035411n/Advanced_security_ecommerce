<?php
session_start();
include 'db_connection.php'; // Database connection

header('Content-Type: application/json'); // JSON response

// Get form data
$payment_method = $_POST['payment-method'] ?? ''; 
$amount = 0;

// Determine amount based on payment method
if ($payment_method === 'credit-card') {
    $amount = $_POST['card-amount'] ?? 0;
} elseif ($payment_method === 'paypal') {
    $amount = $_POST['paypal-amount'] ?? 0;
} elseif ($payment_method === 'cod') {
    $amount = $_POST['cod-amount'] ?? 0;
}

$face_data = $_POST['face_data'] ?? ''; // Face recognition data

// OPTIONAL: Check if user is logged in (remove if not needed)
// If user is not logged in, set a default user ID (e.g., user_id = 1 for now).
$user_id = $_SESSION['user_id'] ?? 1; // Default user ID if not logged in

// Check if face data is received
if (empty($face_data)) {
    echo json_encode(["status" => "error", "message" => "Face recognition failed! Please try again."]);
    exit();
}

// Convert Base64 face image to a SHA256 hash
$face_hash = hash('sha256', base64_decode($face_data));

// Fetch user's stored face hash from the database
$query = "SELECT face_data FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stored_face_hash = trim($row['face_data']); // Remove spaces or newlines

    // Debugging: Log hashes to error log (you can remove in production)
    error_log("Stored Face Hash: " . $stored_face_hash);
    error_log("Submitted Face Hash: " . $face_hash);

    // Compare stored hash with newly submitted hash
    if (hash_equals($stored_face_hash, $face_hash)) { // Secure comparison
        // Insert payment record
        $insertQuery = "INSERT INTO payments (user_id, amount, method, status) VALUES (?, ?, ?, 'Completed')";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sss", $user_id, $amount, $payment_method);
        
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Amount Paid Successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Payment failed! Database error."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Face mismatch! Payment failed."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found!"]);
}
exit();
?>
