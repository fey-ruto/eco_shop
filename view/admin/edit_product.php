<?php
// Include database connection
include('../../db/database.php');

// Retrieve product ID from the query string
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id === 0) {
    die("Error: Invalid product ID.");
}

// Fetch product details from the database
$sql = "SELECT id, title, category, price, description, image FROM products WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: Product not found.");
}

// Fetch product data
$product = $result->fetch_assoc();
$stmt->close();
$db->close();

// Array of categories
$categories = [
    "Biodegradable Pads",
    "Reusable Liners",
    "Organic Tampons",
    "Period Underwear",
    "Menstrual Cups",
    "Heating Pads",
    "Eco Wet Wipes",
    "Panty Liners",
    "Organic Cotton Pads",
    "Period Tracker Journal",
    "Eco-Friendly Bags",
    "Cramps Relief Oil"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Ecomaze</title>
    <link rel="stylesheet" href="../../assets/forms.css">
</head>
<body>
    <header class="green-header">
        <h1>Edit Product</h1>
    </header>
    <main>
        <!-- Form for Editing Product -->
        <form action="../../actions/edit_product.php" method="POST" enctype="multipart/form-data" class="form-container">
            <!-- Product ID (Hidden Field) -->
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">

            <!-- Product Title -->
            <label for="title">Product Name:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($product['title']); ?>" required>

            <!-- Product Category -->
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="">-- Select a Category --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category); ?>" 
                        <?= $product['category'] === $category ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($category); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Product Price -->
            <label for="price">Price ($):</label>
            <input type="number" id="price" name="price" value="<?= htmlspecialchars($product['price']); ?>" required step="0.01" min="0">

            <!-- Product Description -->
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($product['description']); ?></textarea>

            <!-- Image Upload -->
            <label for="image">Product Image:</label>
            <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png">

            <?php if (!empty($product['image'])): ?>
                <label>Current Image:</label>
                <img src="../../assets/uploads/<?= htmlspecialchars(basename($product['image'])); ?>" 
                     alt="Current Image" width="120" height="120">
            <?php endif; ?>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">Update Product</button>
        </form>
    </main>
</body>
</html>
