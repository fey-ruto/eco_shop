<?php
// Include database connection
include('../db/database.php');
error_reporting(E_ALL);
ini_set('',1);

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $title = htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
    $category = htmlspecialchars(trim($_POST['category']), ENT_QUOTES, 'UTF-8');
    $price = floatval($_POST['price']);
    $description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
    $imagePath = null; // To store the path of the uploaded image or URL

    // Validate mandatory fields
    if (empty($title) || empty($category) || empty($price) || empty($description)) {
        die("Error: All fields except the image are required.");
    }

    // Handle file upload if provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Use absolute path for uploads
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/ecomaze_solutions/assets/uploads/'; // Absolute path to uploads folder
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];

        // Validate file type and size
        $allowedFileTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($fileType, $allowedFileTypes)) {
            die("Error: Only JPG, JPEG, and PNG files are allowed.");
        }

        if ($fileSize > 5 * 1024 * 1024) { // Max size: 5MB
            die("Error: File size exceeds the maximum limit of 5MB.");
        }

        // Generate a unique name for the file and move it to the upload directory
        $newFileName = uniqid('product_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
        $absoluteImagePath = $uploadDir . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $absoluteImagePath)) {
            die("Error: Failed to upload the file.");
        }

        // Store the relative path for the database
        $imagePath = '/ecomaze_solutions/assets/uploads/' . $newFileName;
    }

    // Handle image URL if provided and no file was uploaded
    if (empty($imagePath) && !empty($_POST['image_url'])) {
        $imagePath = filter_var($_POST['image_url'], FILTER_VALIDATE_URL);
        if (!$imagePath) {
            die("Error: Invalid image URL.");
        }
    }

    // Insert the product into the database
    $sql = "INSERT INTO products (title, category, price, description, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $db->error);
    }

    $stmt->bind_param("ssdss", $title, $category, $price, $description, $imagePath);

    if ($stmt->execute()) {
        // Redirect to the product management page with success status
        header('Location: ../view/admin/products_manage.php?status=added');
        // header('Location: ../view/admin/products_manage.php');
        exit;
    } else {
        echo "Error: Could not add the product. " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $db->close();
} else {
    // Redirect if accessed without POST
    header('Location: ../view/admin/add_product.php');
    exit;
}
?>
