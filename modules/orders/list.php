<?php
require_once '../../includes/session.php';

$stmt = $pdo->query("
    SELECT o.*, c.name as customer_name 
    FROM orders o 
    JOIN customers c ON o.customer_id = c.id 
    ORDER BY o.order_date DESC
");
$orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders List</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <h2>CRM System</h2>
            <ul>
                <li><a href="../../dashboard.php">Dashboard</a></li>
                <li><a href="../customers/list.php">Customers</a></li>
                <li><a href="../products/list.php">Products</a></li>
                <li><a href="list.php">Orders</a></li>
                <li><a href="../../logout.php">Logout</a></li>
            </ul>
        </nav>
        
        <main class="content">
            <h1>Orders Management</h1>
            <a href="add.php" class="btn-add">Create New Order</a>
            
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $order): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo $order['customer_name']; ?></td>
                        <td><?php echo $order['order_date']; ?></td>
                        <td>$<?php echo $order['total_amount']; ?></td>
                        <td><?php echo $order['status']; ?></td>
                        <td>
                            <a href="view.php?id=<?php echo $order['id']; ?>">View</a>
                            <a href="edit.php?id=<?php echo $order['id']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $order['id']; ?>" onclick="return confirm('Are you sure you want to delete this order? This action cannot be undone.')" style="color: #dc3545;">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>