<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../db_connection.php';

// Fetch users from the database
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="admin.css">
    <script>
        document.addEventListener("contextmenu", function(event) {
            event.preventDefault(); // Disables right-click
            alert("Right-click is disabled on this page!");
        });
    </script>
</head>

<body>

    <header>Manage Users</header>

    <nav>
        <div class="logo">Shop<span style="color: #ffcc00">Ease</span> Admin</div>
        <ul class="nav-links">
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="admin-container">
        <h2>User List</h2>

        <table>
            <tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Email</th>

                <th>Actions</th>
            </tr>
            <?php while ($user = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $user['user_id']; ?></td>
                    <td><?php echo $user['full_name']; ?></td>
                    <td><?php echo $user['email']; ?></td>

                    <td>
                        <a href="edit_user.php?id=<?php echo $user['user_id']; ?>" class="action-btn edit-btn">Edit</a>
                        <a href="delete_user.php?id=<?php echo $user['user_id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
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