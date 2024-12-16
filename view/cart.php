<?php
// Start session and include database connection
if (isset($_GET['message'])) {
    echo "<p style='color: green; font-weight: bold;'>" . htmlspecialchars($_GET['message']) . "</p>";
}

session_start();
include('../db/database.php');

// Initialize variables
$cartItems = [];
$total = 0;

// Fetch cart items from `added_cart_products` table
try {
    $result = $db->query("SELECT * FROM added_cart_products");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }
    } else {
        throw new Exception("Failed to fetch cart items: " . $db->error);
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Handle item removal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $id = intval($_POST['id']);
    try {
        $stmt = $db->prepare("DELETE FROM added_cart_products WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $db->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: cart.php"); // Refresh the page
        exit;
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

// Calculate total price
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Ecomaze</title>
    <link rel="stylesheet" href="../assets/cart.css">
</head>
<body>
    <!-- Header Section -->
    <header class="header-container">
        <!-- Logo -->
        <div class="header-left">
            <img src="../assets/eco_logo.png" alt="Ecomaze Logo" class="logo">
        </div>

        <!-- Page Title -->
        <h1 class="header-title">Your Cart</h1>

        <!-- Home Button -->
        <div class="header-right">
            <button onclick="window.location.href='../index.php';" class="home-btn">Home</button>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <div class="cart-container">
            <div id="cart-items">
                <?php if (empty($cartItems)): ?>
                    <p class='cart-empty-text'>Your cart is empty.</p>
                <?php else: ?>
                    <?php foreach ($cartItems as $item): ?>
                        <div class="cart-item">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                 class="cart-image">
                            <p>
                                <?php echo htmlspecialchars($item['name']); ?> - 
                                $<?php echo number_format($item['price'], 2); ?> x 
                                <?php echo $item['quantity']; ?>
                            </p>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="remove" class="remove-btn">Remove</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <!-- Cart Summary -->
            <div id="cart-summary">
                <h3>Total: $<span id="cart-total"><?php echo number_format($total, 2); ?></span></h3>
                <?php if (!empty($cartItems)): ?>
                    <form method="POST" action="../actions/checkout.php">
                        <button id="checkout-btn" type="submit">Proceed to Checkout</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
