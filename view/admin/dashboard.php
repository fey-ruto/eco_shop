<?php
session_start();

// Dynamic data placeholders - Replace these with values from your database later
$totalUsers = 8; // Example count
$totalProducts = 10;
$pendingSales = 3;
$successfulSales = 5;

// Example recent sales data (to be replaced with database query results)
$recentSales = [
    ['id' => '#R1001', 'number' => 12, 'user' => 'Faith Ruto', 'product' => 'Softcare Pad', 'status' => 'Pending'],
    ['id' => '#R1002', 'number' => 5, 'user' => 'Liam Wale', 'product' => 'Eco wet wipes', 'status' => 'Successfully Sold'],
    ['id' => '#R1003', 'number' => 15, 'user' => 'Priscilla Samory', 'product' => 'Eco Cramps Oil', 'status' => 'Pending'],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecomaze Solutions - Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Link to Chart.js library -->
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Ecomaze Solutions</h2>
        <nav>
            <a href="users.php">User Management</a>
            <a href="products_manage.php">Products Management</a>
            <a href="../../index.php">Home</a>
            <a href="../../index.php" class="logout-link">Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header class="green-header">
            <img src="../../assets/eco_logo.png" alt="Ecomaze Logo" class="logo">
            <h1>Ecomaze Admin Dashboard</h1>
        </header>
    
        <main>
            <!-- Analytics Section -->
            <section class="analytics">
                <div class="card">
                    <h2>Total Users</h2>
                    <p class="number"><?php echo $totalUsers; ?></p>
                </div>
                <div class="card">
                    <h2>Total Products</h2>
                    <p class="number"><?php echo $totalProducts; ?></p>
                </div>
                <div class="card">
                    <h2>Pending Sales</h2>
                    <p class="number"><?php echo $pendingSales; ?></p>
                </div>
                <div class="card">
                    <h2>Successful Sales</h2>
                    <p class="number"><?php echo $successfulSales; ?></p>
                </div>
            </section>

            <!-- Bar Chart -->
            <section class="sales-report">
                <h2>Products Sold Per Month</h2>
                <canvas id="myChart" width="500" height="150"></canvas> <!-- Canvas for dynamic bar chart -->
            </section>

            <!-- Most Searched Products Section -->
            <section class="most-searched">
                <h2>Most Searched Products</h2>
                <div class="product-list">
                    <div class="product-item">
                        <img src="../../assets/product_1.jpg" alt="Softcare Pad">
                        <p>Softcare Pad</p>
                    </div>
                    <div class="product-item">
                        <img src="../../assets/product_7.png" alt="Eco Wet Wipes"> 
                        <p>Eco Wet Wipes</p>
                    </div>
                    <div class="product-item">
                        <img src="../../assets/product_12.jpg" alt="Cramps Relief Oil">
                        <p>Eco Cramps Oil</p>
                    </div>
                    <div class="product-item">
                        <img src="../../assets/product_11.jpeg" alt="Eco Bag">
                        <p>Eco Bag</p>
                    </div>
                </div>
            </section>
            
            <!-- Recent Sales Made Section -->
            <section class="recent-sales">
                <h2>Recent Sales Made</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Submission ID</th>
                            <th>Number</th>
                            <th>User Name</th>
                            <th>Product Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentSales as $sale): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($sale['id']); ?></td>
                            <td><?php echo htmlspecialchars($sale['number']); ?></td>
                            <td><?php echo htmlspecialchars($sale['user']); ?></td>
                            <td><?php echo htmlspecialchars($sale['product']); ?></td>
                            <td><?php echo htmlspecialchars($sale['status']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <!-- JavaScript for Bar Chart -->
    <script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const xValues = ["Jan", "Feb", "Mar", "Apr", "May"];
    const yValues = [80, 60, 40, 100, 50];
    const barColors = ["red", "green", "blue", "orange", "brown"];

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: xValues,
        datasets: [{
          label: 'Submissions',
          data: yValues,
          backgroundColor: barColors,
          borderColor: 'rgba(0, 0, 0, 0.1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        },
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
    </script>
</body>
</html>
