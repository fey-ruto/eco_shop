<?php if (isset($_SESSION['success_message'])): ?>
    <div class="success-message" style="color: green;"><?= $_SESSION['success_message']; ?></div>
    <?php unset($_SESSION['success_message']); ?>
<?php elseif (isset($_SESSION['error_message'])): ?>
    <div class="error-message" style="color: red;"><?= $_SESSION['error_message']; ?></div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<?php
// Start the session
session_start();

// Include database connection
include('../db/database.php');
var_dump($_SESSION);

// Check if user is logged in, otherwise redirect
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php"); // Redirect to homepage if not logged in
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $current_username = htmlspecialchars($row['username']);
    $current_email = htmlspecialchars($row['email']);
} else {
    die("Error fetching user details.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="../assets/account.css"> <!-- Link to CSS file -->
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="header-container">
            <!-- Logo on the left -->
            <div class="header-left">
                <img src="../assets/eco_logo.png" alt="Ecomaze Logo" class="logo">
            </div>
            <!-- Navigation Buttons on the right -->
            <div class="header-right">
                <button class="header-btn" onclick="window.location.href='products.php'">Products</button>
                <button class="header-btn" onclick="window.location.href='../index.php'">Home</button>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="account-container">
        <h1>Account Settings</h1>
        <form id="account-form" method="POST" action="../actions/update_account.php">
            <!-- Current Details -->
            <div class="form-group">
                <label for="current-username">Current Username</label>
                <input type="text" id="current-username" name="current_username" value="<?= $current_username; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="current-email">Current Email</label>
                <input type="email" id="current-email" name="current_email" value="<?= $current_email; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="current-password">Current Password</label>
                <input type="password" id="current-password" value="********" readonly>
            </div>

            <!-- Update Fields -->
            <h2>Update Account Information</h2>
            <div class="form-group">
                <label for="new-username">New Username</label>
                <input type="text" id="new-username" name="new_username" placeholder="Enter new username">
            </div>
            <div class="form-group">
                <label for="new-email">New Email</label>
                <input type="email" id="new-email" name="new_email" placeholder="Enter new email">
            </div>
            <div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new_password" placeholder="Enter new password">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="update-btn">Update Account</button>
        </form>
    </div>
</body>
</html>
