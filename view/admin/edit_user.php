<?php
// Include the database connection
include('../../db/database.php');

// Get the user ID from the query string
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch user details directly using PHP for prefilling (fallback)
$user_data = null;

if ($user_id > 0) {
    $sql = "SELECT id, username AS name, email FROM users WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user_data = $result->fetch_assoc();
    }
    $stmt->close();
}

// Redirect if user not found
if (!$user_data) {
    header("Location: ../../view/user.php?status=user_not_found");
    exit;
}

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Recipe Share</title>
    <link rel="stylesheet" href="../../assets/forms.css">
</head>
<body>
    <header class="green-header">
        <h1>Edit User</h1>
    </header>
    <main>
        <form action="../../actions/edit_user.php" method="POST" class="form-container">
            <!-- Hidden field for user ID -->
            <input type="hidden" id="user_id" name="user_id" value="<?= htmlspecialchars($user_data['id']); ?>" required>

            <!-- Prefill name -->
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user_data['name']); ?>" required>

            <!-- Prefill email -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user_data['email']); ?>" required>

            <button type="submit" class="btn-submit">Update User</button>
        </form>
    </main>

    <!-- JavaScript for dynamic checks (optional fallback for further fetching) -->
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const userId = urlParams.get('id');

        if (!userId) {
            alert('No user ID specified!');
            window.location.href = '../../view/user.php';
        }
    </script>
</body>
</html>
