<?php
session_start(); // Start session

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('../db/database.php');

// Check if user is logged in and has the correct role
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Unauthorized access. Please log in.";
    header("Location: ../index.php");
    exit();
}

$admin_id = $_SESSION['user_id']; // Admin ID from session
echo $admin_id;

// Debugging: Ensure session data is available
if (!$admin_id) {
    $_SESSION['error_message'] = "Session expired. Please log in again.";
    header("Location: ../index.php");
    exit();
}

// Process POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    var_dump($_POST);
    try {
        // Retrieve and sanitize inputs
        $new_username = !empty($_POST['new_username']) ? htmlspecialchars(trim($_POST['new_username'])) : null;
        $new_email = !empty($_POST['new_email']) ? filter_var(trim($_POST['new_email']), FILTER_VALIDATE_EMAIL) : null;
        $new_password = !empty($_POST['new_password']) ? trim($_POST['new_password']) : null;

        // Ensure at least one input is provided
        if (!$new_username && !$new_email && !$new_password) {
            throw new Exception("No updates were provided.");
        }

        $updates = [];
        $params = [];
        $types = "";

        // Check if the admin exists
        $check_admin_sql = "SELECT id FROM users WHERE id = ?";
        $stmt_check = $db->prepare($check_admin_sql);
        $stmt_check->bind_param("i", $admin_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows === 0) {
            throw new Exception("Admin account not found.");
        }

        // Check for duplicate email
        if ($new_email) {
            $email_check_sql = "SELECT id FROM users WHERE email = ? AND id != ?";
            $stmt_email = $db->prepare($email_check_sql);
            $stmt_email->bind_param("si", $new_email, $admin_id);
            $stmt_email->execute();
            if ($stmt_email->get_result()->num_rows > 0) {
                throw new Exception("Email is already taken. Please choose another.");
            }
            $updates[] = "email = ?";
            $params[] = $new_email;
            $types .= "s";
        }

        // Update username if provided
        if ($new_username) {
            $updates[] = "username = ?";
            $params[] = $new_username;
            $types .= "s";
        }

        // Update password if provided
        if ($new_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $updates[] = "password = ?";
            $params[] = $hashed_password;
            $types .= "s";
        }

        // Perform the update if there are changes
        if (!empty($updates)) {
            $updates_sql = implode(", ", $updates);
            $sql = "UPDATE users SET $updates_sql WHERE id = ?";
            $stmt = $db->prepare($sql);

            if ($stmt) {
                $params[] = $admin_id;
                $types .= "i";
                $stmt->bind_param($types, ...$params);

                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        $_SESSION['success_message'] = "Account updated successfully.";
                    } else {
                        throw new Exception("No changes were made.");
                    }
                } else {
                    throw new Exception("Error executing update: " . $stmt->error);
                }
            } else {
                throw new Exception("Error preparing update statement: " . $db->error);
            }

            // Redirect back to the account page
            header("Location: ../view/login.php");
            exit();
        } else {
            throw new Exception("No updates were provided.");
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        print_r($_SESSION);
        header("Location: ../view/login.php");
        exit();
    }
} else {
    // Invalid request method
    $_SESSION['error_message'] = "Invalid request method.";
    print_r($_SESSION);
    header("Location: ../view/account.php");
    
    exit();
}
?>
