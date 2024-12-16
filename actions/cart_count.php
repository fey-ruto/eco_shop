<?php
session_start();
include('../db/database.php');
header('Content-Type: application/json');

// Fetch total quantity of items in cart
$result = $db->query("SELECT SUM(quantity) AS cart_count FROM added_to_cart");
$cartCount = $result ? $result->fetch_assoc()['cart_count'] : 0;

echo json_encode(['cart_count' => $cartCount]);
$db->close();
?>
