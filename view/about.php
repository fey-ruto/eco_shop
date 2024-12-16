<?php
// about.php - About page for Ecomaze Solutions
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Ecomaze</title>
    <link rel="stylesheet" href="../assets/about.css">
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="#" class="logo">
            <img src="../assets/eco_logo.png" alt="Ecomaze Logo" class="logo-img">
        </a>
        <div class="nav-links">
            <a href="../index.php">Home</a>
            <a href="../view/products.php">Products</a>
            <a href="../view/login.php">Login</a>
        </div>
    </div>

    <!-- About Section -->
    <header>
        <h1>About Ecomaze</h1>
        <p>
            <?php
            // Intro text for the about section
            echo "Ecomaze is committed to providing eco-friendly and affordable femcare products for women and girls everywhere. 
            We aim to empower, inspire, and create a positive impact on the environment.";
            ?>
        </p>
        <h2>Our Mission</h2>
        <p>
            <?php
            echo "To make sustainable femcare products accessible to all while preserving the environment for future generations.";
            ?>
        </p>
    </header>

    <!-- Team Section -->
    <section class="team">
        <h2>Meet Our Team</h2>
        <div class="team-container">
            <?php
            // Team members data
            $team_members = [
                ["name" => "Faith Ruto", "role" => "Founder & CEO", "image" => "../assets/faith.jpg"],
                ["name" => "Selorm Azoto", "role" => "Marketing Lead", "image" => "../assets/selorm.jpg"],
                ["name" => "Inez Eyra", "role" => "Sales Lead", "image" => "../assets/inez.jpg"],
            ];

            // Loop through the team members and display dynamically
            foreach ($team_members as $member) {
                echo "
                    <div class='team-member'>
                        <img src='{$member['image']}' alt='{$member['name']}'>
                        <h3>{$member['name']}</h3>
                        <p>{$member['role']}</p>
                    </div>
                ";
            }
            ?>
        </div>
    </section>

    <!-- Our Values -->
    <div class="our-values">
        <h2>Our Values</h2>
        <ul>
            <?php
            // Values data
            $values = [
                "Sustainability" => "Protecting the environment through eco-conscious products.",
                "Affordability" => "Making premium femcare products affordable for everyone.",
                "Empowerment" => "Supporting women and girls to lead confident and healthy lives."
            ];

            // Loop through values and display dynamically
            foreach ($values as $key => $value) {
                echo "<li><strong>{$key}:</strong> {$value}</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>
