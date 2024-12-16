<?php
// Start the session if needed and include the database connection
include('../../db/database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Ecomaze</title>
    <link rel="stylesheet" href="../../assets/forms.css"> <!-- Link to external CSS -->
</head>
<body>
    <header class="green-header">
        <h1>Add New Product</h1>
    </header>
    <main>
        <!-- Add Product Form -->
        <form action="../../actions/add_product.php" method="POST" enctype="multipart/form-data" class="form-container">
            <!-- Product Name -->
            <label for="title">Product Name:</label>
            <input type="text" id="title" name="title" placeholder="Enter product name" required>

            <!-- Category -->
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="">-- Select Category --</option>
                <?php
                // Define categories dynamically (could also be fetched from a database)
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

                // Populate categories dynamically in the dropdown
                foreach ($categories as $category) {
                    echo "<option value=\"" . htmlspecialchars($category) . "\">" . htmlspecialchars($category) . "</option>";
                }
                ?>
            </select>

            <!-- Price -->
            <label for="price">Price (USD):</label>
            <input type="number" id="price" name="price" placeholder="Enter price in USD" required step="0.01" min="0">

            <!-- Product Description -->
            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Enter product description" rows="4" required></textarea>

            <!-- Image Upload -->
            <label for="image">Image Upload:</label>
            <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png">

            <!-- Image URL -->
            <p style="text-align: center;">OR</p>
            <label for="image_url">Image URL:</label>
            <input type="url" id="image_url" name="image_url" placeholder="Enter image URL">

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">Add Product</button>
        </form>
    </main>

    <!-- JavaScript for Image Validation -->
    <script>
        const imageInput = document.getElementById('image');
        const imageUrlInput = document.getElementById('image_url');

        // Allow only one image source (either upload or URL)
        imageInput.addEventListener('change', () => {
            if (imageInput.files.length > 0) {
                imageUrlInput.value = '';
                imageUrlInput.disabled = true;
            } else {
                imageUrlInput.disabled = false;
            }
        });

        imageUrlInput.addEventListener('input', () => {
            if (imageUrlInput.value.trim() !== '') {
                imageInput.value = '';
                imageInput.disabled = true;
            } else {
                imageInput.disabled = false;
            }
        });
    </script>
</body>
</html>
