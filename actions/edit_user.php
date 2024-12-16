<?php
// Include database connection
include('../db/database.php');

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $user_id = intval($_POST['user_id']);
    $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8'); // Assuming 'username' is passed as 'name'
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if (!$email) {
        die("Error: Invalid email address.");
    }

    // Check if the user exists
    $check_sql = "SELECT * FROM users WHERE id = ?";
    $check_stmt = $db->prepare($check_sql);
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows === 0) {
        die("Error: User not found.");
    }

    $check_stmt->close();

    // Update user details in the database
    $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $db->error);
    }

    $stmt->bind_param("ssi", $name, $email, $user_id);

    if ($stmt->execute()) {
        // Redirect to the correct path
        header('Location: ../view/admin/users.php?status=success');
        exit;
    } else {
        error_log("Database Error: " . $stmt->error);
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
} else {
    // Redirect if accessed without POST
    header('Location: ../view/admin/users.php?status=invalid_request');
    exit;
}
?>

