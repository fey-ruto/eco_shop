<?php
session_start();
include('../db/database.php');
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve and decode input JSON
$inputData = json_decode(file_get_contents('php://input'), true);

// Validate input data
if (!isset($inputData['product_id'], $inputData['name'], $inputData['price'], $inputData['image'], $inputData['quantity'])) {
    echo json_encode(['success' => false, 'message' => 'Missing product data.']);
    exit;
}

// Sanitize input values
$productId = filter_var($inputData['product_id'], FILTER_VALIDATE_INT);
$name = htmlspecialchars(trim($inputData['name']));
$price = filter_var($inputData['price'], FILTER_VALIDATE_FLOAT);
$image = filter_var($inputData['image'], FILTER_SANITIZE_URL);
$quantity = filter_var($inputData['quantity'], FILTER_VALIDATE_INT);

// Check for invalid values
if (!$productId || !$name || !$price || !$image || !$quantity) {
    echo json_encode(['success' => false, 'message' => 'Invalid product data.']);
    exit;
}

// Insert or update the product in the `added_cart_products` table
$stmt = $db->prepare("INSERT INTO added_cart_products (product_id, name, price, image, quantity) 
                      VALUES (?, ?, ?, ?, ?)
                      ON DUPLICATE KEY UPDATE quantity = quantity + 1");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $db->error]);
    exit;
}

$stmt->bind_param("isdsi", $productId, $name, $price, $image, $quantity);

if ($stmt->execute()) {
    // Fetch updated cart count
    $countResult = $db->query("SELECT SUM(quantity) AS cart_count FROM added_cart_products");
    $cartCount = $countResult ? $countResult->fetch_assoc()['cart_count'] : 0;

    echo json_encode(['success' => true, 'message' => 'Product added to cart!', 'cart_count' => $cartCount]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add product to cart.']);
}

$stmt->close();
$db->close();
?>
