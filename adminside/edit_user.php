<?php
session_start();

include '../db_connection.php';

// Check if user_id is passed in URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid user ID!'); window.location.href='manage_users.php';</script>";
    exit();
}

$user_id = $_GET['id'];

// Fetch existing user details
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('User not found!'); window.location.href='manage_users.php';</script>";
    exit();
}

$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Update user details (without role)
    $update_sql = "UPDATE users SET full_name = ?, email = ? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $full_name, $email, $user_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('User updated successfully!'); window.location.href='manage_users.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating user. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="edit_user.css" />
    <script>
        document.addEventListener("contextmenu", function(event) {
            event.preventDefault(); // Disables right-click
            alert("Right-click is disabled on this page!");
        });
    </script>
</head>

<body>

    <header>Edit User</header>

    <nav>
        <div class="logo">Shop<span style="color: #ffcc00">Ease</span> Admin</div>
        <ul class="nav-links">
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="admin-container">
        <h2>Update User Details</h2>

        <form action="" method="POST">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <button type="submit">Update User</button>
        </form>
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