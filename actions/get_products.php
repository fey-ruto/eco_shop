<?php
// Include the database connection
include('../db/database.php');

// Fetch products from the database
$sql = "SELECT id, title, category, price, description, image, created_at, updated_at FROM products";
$result = $db->query($sql);

// Check for errors
if (!$result) {
    die(json_encode(['error' => 'Failed to fetch products: ' . $db->error]));
}

// Prepare an array to store the products
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Output the products as JSON
header('Content-Type: application/json');
echo json_encode($products);

// Close the database connection
$db->close();
?>

