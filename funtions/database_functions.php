<?php
// `functions/database.php`

// Get user by email
function getUserByEmail($db, $email) {
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Get admin by email
function getAdminByEmail($db, $email) {
    $query = "SELECT * FROM admins WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Insert new user
function insertUser($db, $username, $email, $password) {
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sss", $username, $email, $password);
    return $stmt->execute();
}

// Insert new admin
function insertAdmin($db, $username, $email, $password) {
    $query = "INSERT INTO admins (username, email, password) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sss", $username, $email, $password);
    return $stmt->execute();
}
?>
