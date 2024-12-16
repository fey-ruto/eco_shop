<?php
// `functions/validation.php`

// Validate email format
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Validate password complexity
function validatePassword($password) {
    $regex = '/^(?=.*[A-Z])(?=.*\d{3,})(?=.*[@#$%^&+=!])[A-Za-z\d@#$%^&+=!]{8,}$/';
    return preg_match($regex, $password);
}

// Validate username length
function validateUsername($username) {
    return strlen($username) >= 5;
}

// Validate role
function validateRole($role) {
    return in_array($role, ['user', 'admin']);
}
?>
