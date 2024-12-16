<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Ecomaze Solutions Shop</title>
    <link rel="stylesheet" href="../assets/signup.css">
</head>
<body>
    <div class="form-container signup-container">
        <h2>Sign Up</h2>

        <!-- Display PHP Server-Side Errors -->
        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="error-box">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); // Clear errors after displaying ?>
        <?php endif; ?>

        <form id="signupForm" action="../actions/signup.php" method="POST">
            <!-- Username Field -->
            <div class="input-group">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    placeholder="Create a username"
                    value="<?php echo isset($_SESSION['old_input']['username']) ? htmlspecialchars($_SESSION['old_input']['username']) : ''; ?>"
                    required
                >
                <small class="hint">Username must be at least 5 characters long.</small>
            </div>

            <!-- Email Field -->
            <div class="input-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="example@domain.com"
                    value="<?php echo isset($_SESSION['old_input']['email']) ? htmlspecialchars($_SESSION['old_input']['email']) : ''; ?>"
                    required
                >
                <small class="hint">Please enter a valid email address.</small>
            </div>

            <!-- Password Field -->
            <div class="input-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Create a password"
                    onfocus="showHints()" 
                    onblur="hideHints()" 
                    oninput="validatePassword()" 
                    required
                >
                <!-- Password Hints -->
                <div id="password-hint" class="password-hint" style="display: none;">
                    <p class="hint invalid" id="length-hint">Be at least 8 characters long</p>
                    <p class="hint invalid" id="uppercase-hint">Contain one uppercase letter</p>
                    <p class="hint invalid" id="special-hint">Contain one special character (@, #, $, etc.)</p>
                    <p class="hint invalid" id="digit-hint">Contain at least three digits</p>
                </div>
                <small class="error-message" id="passwordError"></small>
            </div>

            <!-- Role Dropdown -->
            <div class="input-group">
                <label for="role">Sign Up As</label>
                <select id="role" name="role" required>
                    <option value="" disabled <?php echo empty($_SESSION['old_input']['role']) ? 'selected' : ''; ?>>Choose a role</option>
                    <option value="user" <?php echo (isset($_SESSION['old_input']['role']) && $_SESSION['old_input']['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo (isset($_SESSION['old_input']['role']) && $_SESSION['old_input']['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-primary">Sign Up</button>
        </form>
        <p class="form-footer">Already have an account? <a href="login.php">Login</a></p>
    </div>

    <script>
        // Show the hints when the user focuses on the password field
        function showHints() {
            document.getElementById('password-hint').style.display = 'block';
        }

        // Hide the hints when the user moves away from the password field
        function hideHints() {
            const passwordError = document.getElementById('passwordError');
            if (passwordError.textContent === '') {
                document.getElementById('password-hint').style.display = 'none';
            }
        }

        // Validate the password dynamically
        function validatePassword() {
            const password = document.getElementById('password').value.trim();
            const lengthHint = document.getElementById('length-hint');
            const uppercaseHint = document.getElementById('uppercase-hint');
            const specialHint = document.getElementById('special-hint');
            const digitHint = document.getElementById('digit-hint');
            const passwordError = document.getElementById('passwordError');

            // Check length
            if (password.length >= 8) {
                lengthHint.classList.add('valid');
                lengthHint.classList.remove('invalid');
            } else {
                lengthHint.classList.add('invalid');
                lengthHint.classList.remove('valid');
            }

            // Check uppercase letters
            if (/[A-Z]/.test(password)) {
                uppercaseHint.classList.add('valid');
                uppercaseHint.classList.remove('invalid');
            } else {
                uppercaseHint.classList.add('invalid');
                uppercaseHint.classList.remove('valid');
            }

            // Check special characters
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                specialHint.classList.add('valid');
                specialHint.classList.remove('invalid');
            } else {
                specialHint.classList.add('invalid');
                specialHint.classList.remove('valid');
            }

            // Check for at least three digits
            const digits = password.match(/\d/g) || [];
            if (digits.length >= 3) {
                digitHint.classList.add('valid');
                digitHint.classList.remove('invalid');
            } else {
                digitHint.classList.add('invalid');
                digitHint.classList.remove('valid');
            }

            // Show an error message if the password is invalid
            if (!lengthHint.classList.contains('valid') ||
                !uppercaseHint.classList.contains('valid') ||
                !specialHint.classList.contains('valid') ||
                !digitHint.classList.contains('valid')) {
                passwordError.textContent = 'Password must meet the criteria above.';
            } else {
                passwordError.textContent = ''; // Clear error message
            }
        }
    </script>
</body>
</html>
