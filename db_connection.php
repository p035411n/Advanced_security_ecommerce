<?php
$host = "localhost";    // If using XAMPP or WAMP, keep it "localhost"
$user = "root";         // Default user for XAMPP/WAMP
$pass = "";             // Default password is empty in XAMPP
$dbname = "ecommerce_db"; // Your Database Name






// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {

    die("Connection failed:  " . $conn->connect_error);
}
