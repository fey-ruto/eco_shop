<?php
session_start();

// Database connection (update credentials as needed)
$host = "localhost";
$user = "root";
$password = "";
$database = "ecomaze";

$db = new mysqli($host, $user, $password, $database);

// Check database connection
if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    $errors = []; // Initialize an array to store errors

    // Validate inputs
    if (empty($username) || strlen($username) < 5) {
        $errors[] = "Username must be at least 5 characters long.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d{3,})(?=.*[@#$%^&+=!]).{8,}$/', $password)) {
        $errors[] = "Password must be at least 8 characters long, include one uppercase letter, one special character, and at least three digits.";
    }
    if (empty($role) || !in_array($role, ['user', 'admin'])) {
        $errors[] = "Please select a valid role.";
    }

    // Check for validation errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: signup.php"); // Reload the form with errors
        exit();
    }

    // Check for duplicate username or email
    $table = ($role === 'admin') ? 'admins' : 'users';
    $stmt = $db->prepare("SELECT * FROM $table WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['errors'] = ["Username or email already exists."];
        header("Location: signup.php");
        exit();
    }

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $stmt = $db->prepare("INSERT INTO $table (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        // Registration successful
        $_SESSION['success'] = "Account created successfully! Please log in.";
        header("Location: ../view/login.php"); // Redirect to login page
        exit();
    } else {
        // Error occurred
        $_SESSION['errors'] = ["Something went wrong. Please try again later."];
        header("Location: signup.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        .password-hint { font-size: 0.9rem; color: gray; }
        .hint-valid { color: green; }
        .hint-invalid { color: red; }
        .error-message { color: red; font-size: 0.9rem; }
        .success-message { color: green; font-size: 1rem; }
    </style>
</head>
<body>
    <h1>Sign Up</h1>

    <!-- Display Success Message -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="success-message"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <!-- Display Error Messages -->
    <?php if (!empty($_SESSION['errors'])): ?>
        <ul class="error-message">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <form action="signup.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <div id="password-hint" class="password-hint">
            <p id="length" class="hint-invalid">At least 8 characters</p>
            <p id="uppercase" class="hint-invalid">At least one uppercase letter</p>
            <p id="number" class="hint-invalid">At least 3 numbers</p>
            <p id="special" class="hint-invalid">At least one special character (@, #, $, etc.)</p>
        </div><br><br>

        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="">--Select a role--</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <button type="submit">Sign Up</button>
    </form>

    <script>
        const passwordInput = document.getElementById('password');
        const lengthHint = document.getElementById('length');
        const uppercaseHint = document.getElementById('uppercase');
        const numberHint = document.getElementById('number');
        const specialHint = document.getElementById('special');

        passwordInput.addEventListener('input', () => {
            const password = passwordInput.value;

            // Length validation
            if (password.length >= 8) lengthHint.classList.add('hint-valid');
            else lengthHint.classList.remove('hint-valid');

            // Uppercase letter
            if (/[A-Z]/.test(password)) uppercaseHint.classList.add('hint-valid');
            else uppercaseHint.classList.remove('hint-valid');

            // Numbers
            if ((password.match(/\d/g) || []).length >= 3) numberHint.classList.add('hint-valid');
            else numberHint.classList.remove('hint-valid');

            // Special character
            if (/[!@#$%^&+=]/.test(password)) specialHint.classList.add('hint-valid');
            else specialHint.classList.remove('hint-valid');
        });
    </script>
</body>
</html>
