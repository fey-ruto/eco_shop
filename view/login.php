<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ecomaze Solutions Shop</title>
    <link rel="stylesheet" href="../assets/login.css">
</head>
<body>
    <div class="form-container login-container">
        <h2>Welcome Back!</h2>

        <!-- Display Success or Error Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-box">
                <p><?php echo htmlspecialchars($_SESSION['success']); ?></p>
            </div>
            <?php unset($_SESSION['success']); // Clear success message ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="error-box">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); // Clear error messages ?>
        <?php endif; ?>

        <!-- Login Form -->
        <form id="loginForm" action="../actions/login.php" method="POST">
            <!-- Email Field -->
            <div class="input-group">
                <label for="email">Email</label>
                <input 
                    type="text" 
                    id="email" 
                    name="email" 
                    placeholder="example@domain.com"
                    value="<?php echo isset($_SESSION['old_input']['email']) ? htmlspecialchars($_SESSION['old_input']['email']) : ''; ?>"
                    oninput="validateEmail()"
                    required
                >
                <small class="error-message" id="emailError"></small>
            </div>

            <!-- Password Field -->
            <div class="input-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Enter your password"
                    oninput="validatePassword()"
                    required
                >
                <small class="error-message" id="passwordError"></small>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-primary">Log In</button>
        </form>
        <p class="form-footer">New to Ecomaze Shop? <a href="signup.php">Sign Up</a></p>
    </div>

    <script>
        // Real-time Email Validation
        function validateEmail() {
            const email = document.getElementById('email').value.trim();
            const emailError = document.getElementById('emailError');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email === '') {
                emailError.textContent = 'Email is required.';
            } else if (!emailRegex.test(email)) {
                emailError.textContent = 'Invalid email format.';
            } else {
                emailError.textContent = ''; // Clear error message
            }
        }

        // Real-time Password Validation
        function validatePassword() {
            const password = document.getElementById('password').value.trim();
            const passwordError = document.getElementById('passwordError');

            if (password === '') {
                passwordError.textContent = 'Password is required.';
            } else {
                passwordError.textContent = ''; // Clear error message
            }
        }

        // Final Form Validation on Submission
        document.getElementById('loginForm').addEventListener('submit', function (event) {
            validateEmail();
            validatePassword();

            const emailError = document.getElementById('emailError').textContent;
            const passwordError = document.getElementById('passwordError').textContent;

            // Prevent submission if errors exist
            if (emailError || passwordError) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>


