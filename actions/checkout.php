<?php
session_start();
include('../db/database.php');

// Fetch cart items from `added_cart_products` table
$result = $db->query("SELECT * FROM added_cart_products");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Insert into ordered_products table
        $stmt = $db->prepare("INSERT INTO ordered_products (product_id, user_id, name, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL; // Optional user ID
        $stmt->bind_param("iisdis", $row['product_id'], $userId, $row['name'], $row['price'], $row['quantity'], $row['image']);
        $stmt->execute();
    }

    // Clear the cart table after checkout
    $db->query("DELETE FROM added_cart_products");

    // Close the statement and connection
    $stmt->close();
    $db->close();

    // Redirect back to cart.php with a success message
    header("Location: ../view/cart.php?message=Order+placed+successfully");
    exit;
} else {
    echo "Failed to process order.";
    $db->close();
}
?>
