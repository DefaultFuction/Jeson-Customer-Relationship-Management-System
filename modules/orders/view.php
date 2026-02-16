<?php
require_once '../../includes/session.php';

$id = $_GET['id'];

$orderStmt = $pdo->query("SELECT o.*, c.name as customer_name, c.email, c.phone FROM orders o JOIN customers c ON o.customer_id = c.id WHERE o.id=$id");
$order = $orderStmt->fetch();

$itemsStmt = $pdo->query("SELECT oi.*, p.name as product_name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id=$id");
$items = $itemsStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order</title>
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
            <h1>Order #<?php echo $order['id']; ?></h1>
            
            <div class="action-buttons" style="margin-bottom: 20px;">
                <a href="edit.php?id=<?php echo $order['id']; ?>" class="btn-add" style="background: #28a745;">Edit Order</a>
                <a href="delete.php?id=<?php echo $order['id']; ?>" onclick="return confirm('Are you sure you want to delete this order? This action cannot be undone.')" class="btn-add" style="background: #dc3545;">Delete Order</a>
                <a href="list.php" class="btn-add" style="background: #6c757d;">Back to List</a>
            </div>
            
            <div class="order-info" style="background: white; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
                <h2>Customer Information</h2>
                <p><strong>Name:</strong> <?php echo $order['customer_name']; ?></p>
                <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
                <p><strong>Phone:</strong> <?php echo $order['phone']; ?></p>
                <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
                <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
                <p><strong>Total Amount:</strong> $<?php echo $order['total_amount']; ?></p>
            </div>
            
            <h2>Order Items</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items as $item): ?>
                    <tr>
                        <td><?php echo $item['product_name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo $item['price']; ?></td>
                        <td>$<?php echo $item['quantity'] * $item['price']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>$<?php echo $order['total_amount']; ?></th>
                    </tr>
                </tfoot>
            </table>
        </main>
    </div>
</body>
</html>