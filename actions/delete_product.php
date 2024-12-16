<?php
// Include database connection
include('../db/database.php');

// Enable error reporting for debugging (optional during development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if an ID is provided and valid
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $product_id = intval($_GET['id']); // Sanitize and convert to integer

    // Prepare the SQL statement to delete the product
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        // Log and redirect with an error message
        error_log("Delete statement preparation failed: " . $db->error, 3, "../logs/errors.log");
        header('Location: ../view/admin/products_manage.php?status=stmt_error');
        exit;
    }

    // Bind the product ID to the statement
    $stmt->bind_param("i", $product_id);

    // Execute the query
    if ($stmt->execute()) {
        // Check if rows were affected
        if ($stmt->affected_rows > 0) {
            header('Location: ../view/admin/products_manage.php?status=deleted');
        } else {
            // Log if no rows matched the given ID
            error_log("No product found with ID: $product_id", 3, "../logs/errors.log");
            header('Location: ../view/admin/products_manage.php?status=not_found');
        }
    } else {
        // Log query execution error
        error_log("Failed to execute DELETE query: " . $stmt->error, 3, "../logs/errors.log");
        header('Location: ../view/admin/products_manage.php?status=delete_error');
    }

    // Close the statement
    $stmt->close();
} else {
    // Log invalid requests
    error_log("Invalid or missing product ID in delete request.", 3, "../logs/errors.log");
    header('Location: ../view/admin/products_manage.php?status=invalid_request');
}

// Close the database connection
$db->close();
exit;
?>
