<?php
// Include database connection
include('../../db/database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products and Orders Management</title>
    <link rel="stylesheet" href="../../assets/admin.css"> <!-- Link to CSS -->
</head>
<body>
    <!-- Sidebar Section -->
    <div class="sidebar">
        <h2>Ecomaze Solutions</h2>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="users.php">User Management</a>
            <a href="products_manage.php">Products Management</a>
            <a href="../../index.php">Home</a>
            <a href="../../index.php" class="logout-link">Logout</a>
        </nav>
    </div>

    <!-- Main Content Section -->
    <div class="main-content">
        <!-- Header Section -->
        <header class="green-header">
            <img src="../../assets/eco_logo.png" alt="Ecomaze Logo" class="logo">
            <h1>Products Management</h1>
            <button class="add-btn" onclick="window.location.href='add_product.php';">Add Product</button>
        </header>

        <!-- Products Table -->
        <section>
            <h2>Available Products</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="product-table-body">
                    <!-- Product rows will be dynamically inserted here -->
                </tbody>
            </table>
        </section>

        <!-- Ordered Products Table -->
        <section style="margin-top: 50px;">
            <h2>Ordered Products</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Image</th>
                        <th>Ordered At</th>
                    </tr>
                </thead>
                <tbody id="ordered-products-body">
                    <!-- Ordered products rows will be dynamically inserted here -->
                </tbody>
            </table>
        </section>
    </div>

    <!-- JavaScript to Fetch and Display Products and Ordered Products -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
    const productTableBody = document.getElementById('product-table-body');
    const orderedProductsBody = document.getElementById('ordered-products-body');

    // Fetch and display product data
    async function fetchProducts() {
        try {
            const response = await fetch('../../actions/get_products.php');
            if (!response.ok) throw new Error('Failed to fetch product data.');

            const products = await response.json();
            productTableBody.innerHTML = ''; // Clear rows

            if (products.length === 0) {
                productTableBody.innerHTML = `<tr><td colspan="7" style="text-align: center;">No products available.</td></tr>`;
                return;
            }

            products.forEach(product => {
                productTableBody.innerHTML += `
                    <tr>
                        <td>${product.id}</td>
                        <td>${product.title}</td>
                        <td>${product.category}</td>
                        <td>$${parseFloat(product.price).toFixed(2)}</td>
                        <td>${product.description.length > 50 ? product.description.substring(0, 50) + '...' : product.description}</td>
                        <td>
                            <img src="${product.image}" alt="${product.title}" width="80" height="80">
                        </td>
                        <td>
                            <button class="edit-btn" onclick="window.location.href='edit_product.php?id=${product.id}'">Edit</button>
                            <button class="delete-btn" data-id="${product.id}">Delete</button>
                        </td>
                    </tr>
                `;
            });

            // Attach event listeners dynamically to delete buttons
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const productId = button.getAttribute('data-id');
                    confirmDelete(productId);
                });
            });
        } catch (error) {
            console.error('Error fetching products:', error);
            productTableBody.innerHTML = `<tr><td colspan="7" style="text-align: center; color: red;">Error loading products: ${error.message}</td></tr>`;
        }
    }

    // Fetch and display ordered products data
    async function fetchOrderedProducts() {
        try {
            const response = await fetch('../../actions/get_ordered_products.php');
            if (!response.ok) throw new Error('Failed to fetch ordered products data.');

            const orders = await response.json();
            orderedProductsBody.innerHTML = ''; // Clear rows

            if (orders.length === 0) {
                orderedProductsBody.innerHTML = `<tr><td colspan="8" style="text-align: center;">No orders available.</td></tr>`;
                return;
            }

            orders.forEach(order => {
                orderedProductsBody.innerHTML += `
                    <tr>
                        <td>${order.id}</td>
                        <td>${order.product_id}</td>
                        <td>${order.user_id || 'N/A'}</td>
                        <td>${order.name}</td>
                        <td>$${parseFloat(order.price).toFixed(2)}</td>
                        <td>${order.quantity}</td>
                        <td><img src="${order.image}" alt="${order.name}" width="80"></td>
                        <td>${order.ordered_at}</td>
                    </tr>
                `;
            });
        } catch (error) {
            console.error('Error fetching ordered products:', error);
            orderedProductsBody.innerHTML = `<tr><td colspan="8" style="text-align: center; color: red;">Error loading orders: ${error.message}</td></tr>`;
        }
    }

    // Confirm delete function for products
    async function confirmDelete(productId) {
        const confirmation = confirm('Are you sure you want to delete this product?');
        if (confirmation) {
            try {
                const response = await fetch(`../../actions/delete_product.php?id=${productId}`, { method: 'GET' });
                if (!response.ok) throw new Error('Failed to delete product.');

                alert('Product deleted successfully.');
                await fetchProducts(); // Reload products table
            } catch (error) {
                console.error('Error deleting product:', error);
                alert('Failed to delete product. Please try again.');
            }
        }
    }

    // Initial load: Fetch products and orders
    fetchProducts();
    fetchOrderedProducts();
});
</script>
</body>
</html>
