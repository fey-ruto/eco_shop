<?php
// Include the database connection
include('../db/database.php');

// Check if an ID is provided via GET
if (isset($_GET['id'])) {
    // Sanitize the ID to prevent SQL injection
    $user_id = intval($_GET['id']);

    // Check if the user exists
    $check_sql = "SELECT * FROM users WHERE id = ?";
    $check_stmt = $db->prepare($check_sql);
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows === 0) {
        // User does not exist
        $check_stmt->close();
        $db->close();
        header('Location: ../../view/admin/users.php?status=user_not_found');
        exit;
    }

    $check_stmt->close();

    // Delete the user from the database
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $delete_stmt = $db->prepare($delete_sql);
    $delete_stmt->bind_param("i", $user_id);

    if ($delete_stmt->execute()) {
        $delete_stmt->close();
        $db->close();
        // Redirect with success status
        header('Location: ../view/admin/users.php?status=success');
        exit;
    } else {
        $delete_stmt->close();
        $db->close();
        // Redirect with failure status
        header('Location: ../view/admin/users.php?status=error');
        exit;
    }
} else {
    // Redirect if no ID is provided
    header('Location: ../view/admin/users.php?status=invalid_request');
    exit;
}
?>
