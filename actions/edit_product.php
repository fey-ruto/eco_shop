<?php
// Start by including your database connection
include('../db/database.php'); // Adjust the path to match your structure

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $product_id = intval($_POST['product_id']); // Ensure the product ID is an integer
    $title = htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
    $category = htmlspecialchars(trim($_POST['category']), ENT_QUOTES, 'UTF-8');
    $price = floatval($_POST['price']); // Ensure the price is a float
    $description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8');

    // Check if product_id is valid
    if ($product_id <= 0) {
        die("Error: Invalid product ID.");
    }

    // Handle the uploaded image if provided
    $imagePath = null; // Default value for the image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../assets/uploads/'; // Correct path to uploads folder
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];

        // Validate file type and size
        $allowedFileTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($fileType, $allowedFileTypes)) {
            die('Error: Only JPG, JPEG, and PNG files are allowed.');
        }

        if ($fileSize > 5 * 1024 * 1024) { // Max size: 5MB
            die('Error: File size exceeds the maximum allowed limit of 5MB.');
        }

        // Ensure the uploads directory exists
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate a unique name for the uploaded file
        $newFileName = uniqid('product_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
        $uploadFilePath = $uploadDir . $newFileName;

        // Move the uploaded file to the target directory
        if (!move_uploaded_file($fileTmpPath, $uploadFilePath)) {
            die('Error: Failed to upload the file.');
        }

        // Set the image path relative to the project root
        $imagePath = 'assets/uploads/' . $newFileName;
    }

    // Update product details in the database
    $sql = "UPDATE products 
            SET title = ?, category = ?, price = ?, description = ?, image = COALESCE(?, image)
            WHERE id = ?";

    // Prepare the statement
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $db->error);
    }

    // Bind parameters (use $imagePath if updated, else null)
    $stmt->bind_param("ssdssi", $title, $category, $price, $description, $imagePath, $product_id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the product management page with success status
        header('Location: ../view/admin/products_manage.php?status=success');
        exit;
    } else {
        // Handle execution errors
        echo 'Error updating product: ' . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $db->close();
} else {
    // Redirect if accessed without POST
    header('Location: ../view/admin/products_manage.php?status=invalid_request');
    exit;
}
?>

