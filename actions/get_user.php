<?php
// Include database connection
include('../db/database.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set response content type to JSON
header('Content-Type: application/json');

// Get the user ID from the query string
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($user_id <= 0) {
    echo json_encode(["error" => "Invalid user ID"]);
    exit;
}

// Fetch user details from the database
$sql = "SELECT id, username AS name, email FROM users WHERE id = ?";
$stmt = $db->prepare($sql);

if (!$stmt) {
    echo json_encode(["error" => "Failed to prepare statement: " . $db->error]);
    exit;
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    echo json_encode($user); // Return user details as JSON
} else {
    echo json_encode(["error" => "User not found"]);
}

// Close the database connection
$stmt->close();
$db->close();
?>
