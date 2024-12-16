<?php
session_start();
include('../db/database.php');

// Fetch cart items from database
$cartItems = [];
$result = $db->query("SELECT * FROM added_cart_products");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
} else {
    die("Failed to fetch cart items: " . $db->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        <?php $grandTotal = 0; ?>
        <?php foreach ($cartItems as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']); ?></td>
                <td>$<?= number_format($item['price'], 2); ?></td>
                <td><?= $item['quantity']; ?></td>
                <td>$<?= number_format($item['price'] * $item['quantity'], 2); ?></td>
            </tr>
            <?php $grandTotal += $item['price'] * $item['quantity']; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Grand Total:</strong></td>
            <td><strong>$<?= number_format($grandTotal, 2); ?></strong></td>
        </tr>
    </table>

    <form method="POST" action="../actions/checkout.php">
        <button type="submit">Confirm and Place Order</button>
    </form>
</body>
</html>
