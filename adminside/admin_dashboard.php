<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../db_connection.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <script>
        document.addEventListener("contextmenu", function(event) {
            event.preventDefault(); // Disables right-click
            alert("Right-click is disabled on this page!");
        });
    </script>
</head>

<body>

    <header>Admin Dashboard</header>

    <nav>
        <div class="logo">Shop<span style="color: #ffcc00">Ease</span> Admin</div>
        <ul class="nav-links">
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="admin-container">
        <h2>Welcome, Admin!</h2>

        <div class="admin-menu">
            <a href="manage_users.php">Manage Users</a>
            <a href="manage_orders.php">Manage Orders</a>
            <a href="manage_products.php">Manage Products</a>
        </div>

        <p>Here you can control users, products, and orders.</p>
    </div>

    <footer>
        &copy; 2025 ShopEase Admin Panel. All Rights Reserved.
    </footer>

</body>
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

</html>