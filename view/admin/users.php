<?php
// Include the database connection
include('../../db/database.php');

// Correct query to fetch `username` instead of `name`
$sql = "SELECT id, username AS name, email FROM users";
$result = $db->query($sql);

// Check for database query errors
if (!$result) {
    die("Error executing query: " . $db->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../../assets/admin.css"> <!-- Link to CSS -->
</head>
<body>
    <div class="sidebar">
        <h2>Ecomaze Solutions</h2>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="products_manage.php">Products Management</a>
            <a href="../../index.php">Home</a>
            <a href="../../index.php" class="logout-link">Logout</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="green-header">
            <img src="../../assets/eco_logo.png" alt="Ecomaze Logo" class="logo">
            <h1>User Management</h1>
        </header>
        <main>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Render user data dynamically
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>"; // `username` aliased as `name`
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>
                                <button 
                                    class='edit-btn'
                                    onclick=\"window.location.href='edit_user.php?id=" . htmlspecialchars($row['id']) . "';\">
                                    Edit
                                </button>
                                <button 
                                    class='delete-btn' 
                                    onclick=\"if (confirm('Are you sure you want to delete this user?')) { window.location.href='../../actions/delete_user.php?id=" . htmlspecialchars($row['id']) . "'; }\">
                                    Delete
                                </button>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>

<?php
// Close database connection
$db->close();
?>
