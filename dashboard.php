<?php
require_once 'includes/session.php';
require_once 'includes/functions.php';

$totalCustomers = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

$recentCustomers = $pdo->query("SELECT * FROM customers ORDER BY created_at DESC LIMIT 5")->fetchAll();
$serverInfo = getServerInfo();

if(isset($_POST['check_server'])) {
    $pingResult = executeSystemCommand("ping -c 4 localhost");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <h2>CRM System</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="modules/customers/list.php">Customers</a></li>
                <li><a href="modules/products/list.php">Products</a></li>
                <li><a href="modules/orders/list.php">Orders</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        
        <main class="content">
            <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
            
            <div class="stats">
                <div class="stat-card">
                    <h3>Total Customers</h3>
                    <p><?php echo $totalCustomers; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total Products</h3>
                    <p><?php echo $totalProducts; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total Orders</h3>
                    <p><?php echo $totalOrders; ?></p>
                </div>
            </div>
            
            <div class="server-info">
                <h2>Server Information</h2>
                <form method="POST">
                    <button type="submit" name="check_server">Check Server Status</button>
                </form>
                <?php if(isset($pingResult)): ?>
                    <pre><?php echo $pingResult; ?></pre>
                <?php endif; ?>
                
                <table>
                    <tr><th>Hostname</th><td><?php echo $serverInfo['hostname']; ?></td></tr>
                    <tr><th>Operating System</th><td><?php echo $serverInfo['os']; ?></td></tr>
                    <tr><th>PHP Version</th><td><?php echo $serverInfo['php_version']; ?></td></tr>
                    <tr><th>Server Software</th><td><?php echo $serverInfo['server_software']; ?></td></tr>
                    <tr><th>Disk Free Space</th><td><?php echo round($serverInfo['disk_free'] / 1024 / 1024 / 1024, 2); ?> GB</td></tr>
                </table>
            </div>
            
            <div class="recent-customers">
                <h2>Recent Customers</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Company</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recentCustomers as $customer): ?>
                        <tr>
                            <td><?php echo $customer['name']; ?></td>
                            <td><?php echo $customer['email']; ?></td>
                            <td><?php echo $customer['phone']; ?></td>
                            <td><?php echo $customer['company']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>