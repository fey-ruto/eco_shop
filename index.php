<?php
session_start(); // Start a session for dynamic features like login/logout

// Placeholder variables for future dynamic content
$isLoggedIn = isset($_SESSION['user']); // Example: Check if user is logged in
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Ecomaze</title>
    <link rel="stylesheet" href="assets/index.css"> <!-- Adjusted path for root-level CSS -->
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="#" class="logo">
            <img src="assets/eco_logo.png" alt="Ecomaze Logo" class="logo-img"> <!-- Adjusted path -->
        </a>
        <div class="nav-links">
            <a href="view/about.php">About</a>
            <a href="view/products.php">Products</a>
            <?php if ($isLoggedIn): ?>
                <!-- Show logout if user is logged in -->
                <a href="actions/logout.php">Logout</a>
            <?php else: ?>
                <!-- Show login if user is not logged in -->
                <a href="view/login.php">Login</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Welcome Section (Centered Content) -->
    <header>
        <h1>Welcome to Ecomaze Solutions</h1>
        <p>Your one-stop shop for affordable and eco-friendly femcare products.</p>
    </header>

    <!-- Features Section -->
    <section class="features">
        <h2>Why Choose Ecomaze?</h2>
        <ul>
            <li>Eco-friendly products</li>
            <li>Affordable pricing</li>
            <li>Quick delivery</li>
        </ul>
        <div class="cta">
            <button onclick="window.location.href='view/products.php';">Get Started</button>
        </div>
    </section>
</body>
</html>

