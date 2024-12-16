<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        .password-hint {
            font-size: 0.9rem;
            color: gray;
        }
        .hint-valid {
            color: green;
        }
        .hint-invalid {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Signup</h1>
    <?php
    session_start();
    if (!empty($_SESSION['errors'])) {
        echo '<ul>';
        foreach ($_SESSION['errors'] as $error) {
            echo "<li style='color: red;'>$error</li>";
        }
        echo '</ul>';
        unset($_SESSION['errors']);
    }
    ?>
    <form action="../controller/signup_handler.php" method="POST">
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
            <p id="special" class="hint-invalid">At least one special character (@, #, $, %, etc.)</p>
        </div>
        <br><br>

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

        passwordInput.addEventListener('input', function () {
            const password = passwordInput.value;

            // Validate length
            if (password.length >= 8) {
                lengthHint.classList.add('hint-valid');
                lengthHint.classList.remove('hint-invalid');
            } else {
                lengthHint.classList.add('hint-invalid');
                lengthHint.classList.remove('hint-valid');
            }

            // Validate uppercase letter
            if (/[A-Z]/.test(password)) {
                uppercaseHint.classList.add('hint-valid');
                uppercaseHint.classList.remove('hint-invalid');
            } else {
                uppercaseHint.classList.add('hint-invalid');
                uppercaseHint.classList.remove('hint-valid');
            }

            // Validate numbers
            if ((password.match(/\d/g) || []).length >= 3) {
                numberHint.classList.add('hint-valid');
                numberHint.classList.remove('hint-invalid');
            } else {
                numberHint.classList.add('hint-invalid');
                numberHint.classList.remove('hint-valid');
            }

            // Validate special characters
            if (/[!@#$%^&+=]/.test(password)) {
                specialHint.classList.add('hint-valid');
                specialHint.classList.remove('hint-invalid');
            } else {
                specialHint.classList.add('hint-invalid');
                specialHint.classList.remove('hint-valid');
            }
        });
    </script>
</body>
</html>
