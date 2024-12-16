<?php
// Include database connection
include('../db/database.php');

// Set content type to JSON
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize an empty array for ordered products
$orderedProducts = [];

// Fetch ordered products from the database
try {
    $query = "SELECT id, product_id, user_id, name, price, quantity, image, ordered_at FROM ordered_products ORDER BY ordered_at DESC";
    $result = $db->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $orderedProducts[] = $row;
        }
        echo json_encode($orderedProducts); // Send data as JSON
    } else {
        throw new Exception("Error fetching ordered products: " . $db->error);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

// Close database connection
$db->close();
?>
