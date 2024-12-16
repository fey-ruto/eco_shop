<?php
session_start();
include('../db/database.php'); // Include database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch and sanitize input data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $errors = [];

    // Server-side validation
    if (empty($email)) {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }

    // If validation fails, return error messages
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ../view/login.php'); // Redirect back to login page
        exit();
    }

    // First, check if the user is an admin
    $query = "SELECT * FROM admins WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $admin['password'])) {
            // Set session variables for admin
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['fname'] = $admin['fname'];
            $_SESSION['lname'] = $admin['lname'];

            // Redirect to admin dashboard
            header('Location: ../view/admin/dashboard.php');
            exit();
        } else {
            $_SESSION['errors'] = ['password' => 'Incorrect password.'];
            header('Location: ../view/login.php');
            exit();
        }
    }

    // If not an admin, check the users table
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables for user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fname'] = $user['fname'];
            $_SESSION['lname'] = $user['lname'];

            // Redirect to Landing page
            header('Location: ../index.php');
            exit();
        } else {
            $_SESSION['errors'] = ['password' => 'Incorrect password.'];
            header('Location: ../view/login.php');
            exit();
        }
    } else {
        $_SESSION['errors'] = ['email' => 'No account found with this email.'];
        header('Location: ../view/login.php');
        exit();
    }
}
?>
