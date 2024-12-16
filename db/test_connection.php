<?php
include('database.php'); // Include the database connection

if ($db->ping()) {
    echo "Database connected successfully!";
} else {
    echo "Error: " . $db->connect_error;
}
?>
