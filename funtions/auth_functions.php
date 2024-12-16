<?php
// `functions/auth.php`

// Check if the user is logged in
function checkLoginStatus() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../view/login.html');
        exit();
    }
}

// Determine if the user is an admin
function isAdmin($role) {
    return $role === 'admin';
}

// Redirect user based on role
function redirectBasedOnRole($role) {
    if ($role === 'admin') {
        header('Location: ../view/dashboard.html');
    } else {
        header('Location: ../index.html');
    }
    exit();
}
?>
