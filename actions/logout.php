<?php
session_start(); // Start the session

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the correct login page
header("Location: ../view/login.php"); // Adjust the path accordingly
exit();
?>
