<?php
// Include database connection
include('../db/database.php');

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = $db->query($sql);

// Original loop
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Ecomaze</title>
    <link rel="stylesheet" href="../assets/products.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="header-container">
            <div class="header-left">
                <img src="../assets/eco_logo.png" alt="Ecomaze Logo">
            </div>
            <div class="header-right">
                <div class="cart">
                    <div class="cart-icon">
                        <img src="../assets/cart_icon.png" alt="Cart">
                        <span class="cart-count">0</span>
                    </div>
                    <a href="cart.php">View Cart</a>
                </div>
                <div class="account">
                    <a href="account.php">Account</a>
                </div>
                <button class="back-btn" onclick="window.location.href='../index.php';">Home</button>
            </div>
        </div>
        <h1>Our Products</h1>
        <input type="text" id="search" placeholder="Search products...">
    </header>

    <!-- Main Content -->
    <div class="content-container" style="display: flex;">
        <!-- Filters -->
        <div class="filter-container">
            <h3>Filter Products</h3>
            <div class="filter-section">
                <h4>Category</h4>
                <select id="filter-category">
                    <option value="">All Categories</option>
                    <?php
                    $categories = [
                        "Biodegradable Pads", "Reusable Liners", "Organic Tampons", 
                        "Period Underwear", "Menstrual Cups", "Heating Pads", 
                        "Eco Wet Wipes", "Panty Liners", "Organic Cotton Pads", 
                        "Period Tracker Journal", "Eco-Friendly Bags", "Cramps Relief Oil"
                    ];
                    foreach ($categories as $category) {
                        echo "<option value='$category'>$category</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="filter-section">
                <h4>Price</h4>
                <select id="filter-price">
                    <option value="">All Prices</option>
                    <option value="low">Below $10</option>
                    <option value="medium">$10 - $20</option>
                    <option value="high">Above $20</option>
                </select>
            </div>
            <button id="apply-filters">Apply Filters</button>
        </div>

        <!-- Products Grid -->
        <div class="products-grid">
    <?php foreach ($products as $product): ?>
        <div class="product-item" 
             data-id="<?= $product['id'] ?>" 
             data-category="<?= htmlspecialchars($product['category']) ?>" 
             data-price="<?= $product['price'] ?>">
             
            <!-- Product Image -->
            <img src="../..<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>">
            
            <!-- Product Title -->
            <h2><?= htmlspecialchars($product['title']) ?></h2>
            
            <!-- Product Category -->
            <p class="category">Category: <?= htmlspecialchars($product['category']) ?></p> <!-- Added Category -->
            
            <!-- Product Price -->
            <p>$<?= number_format($product['price'], 2) ?></p>
            
            <!-- Product Description -->
            <p><?= htmlspecialchars($product['description']) ?></p>
            
            <!-- Add to Cart Button -->
            <button class="cart-btn">Add to Cart</button>
        </div>
    <?php endforeach; ?>
</div>

    <!-- JavaScript for Search, Filters, and Cart -->
    <script>
document.addEventListener("DOMContentLoaded", () => {
    const addToCartButtons = document.querySelectorAll(".cart-btn");
    const cartCountElement = document.querySelector(".cart-count");
    const filterButton = document.getElementById("apply-filters");
    const categoryFilter = document.getElementById("filter-category");
    const priceFilter = document.getElementById("filter-price");
    const productItems = document.querySelectorAll(".product-item");

    // Function to update cart count
    function updateCartCount(cartCount) {
        cartCountElement.textContent = cartCount || 0;
    }

    // Event listener for "Add to Cart" button
    addToCartButtons.forEach(button => {
        button.addEventListener("click", (e) => {
            const productElement = e.target.closest(".product-item");
            const productId = productElement.getAttribute("data-id");
            const productName = productElement.querySelector("h2").textContent;
            const productPrice = parseFloat(productElement.getAttribute("data-price"));
            const productImage = productElement.querySelector("img").src;

            // Send product data to the actions add_to_cart.php
            fetch("../actions/add_to_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    product_id: productId,
                    name: productName,
                    price: productPrice,
                    image: productImage,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`${productName} added to cart!`);
                    updateCartCount(data.cart_count); // Update the cart count
                } else {
                    alert(`Error: ${data.message}`);
                }
            })
            .catch(error => {
                console.error('Error adding product to cart:', error);
                alert("An error occurred. Please try again.");
            });
        });
    });

    // Fetch initial cart count
    fetch("../actions/cart_count.php")
        .then(response => response.json())
        .then(data => {
            updateCartCount(data.cart_count);
        })
        .catch(error => console.error('Error fetching cart count:', error));

    // Filter functionality for category and price
    filterButton.addEventListener("click", () => {
        const selectedCategory = categoryFilter.value.toLowerCase();
        const selectedPrice = priceFilter.value;

        productItems.forEach(item => {
            const productCategory = item.getAttribute("data-category").toLowerCase();
            const productPrice = parseFloat(item.getAttribute("data-price"));

            let matchesCategory = selectedCategory === "" || productCategory === selectedCategory;
            let matchesPrice = 
                selectedPrice === "" ||
                (selectedPrice === "low" && productPrice < 10) ||
                (selectedPrice === "medium" && productPrice >= 10 && productPrice <= 20) ||
                (selectedPrice === "high" && productPrice > 20);

            // Show or hide product items based on filters
            if (matchesCategory && matchesPrice) {
                item.style.display = "flex"; /* Ensures flex layout is maintained */
            } else {
                item.style.display = "none";
            }
        });
    });
});
</script>

</body>
</html>





