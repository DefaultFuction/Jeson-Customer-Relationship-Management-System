<?php
require_once '../../includes/session.php';

$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    
    $pdo->exec("UPDATE orders SET status='$status' WHERE id=$id");
    
    header("Location: list.php");
    exit();
}

$orderStmt = $pdo->query("SELECT * FROM orders WHERE id=$id");
$order = $orderStmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
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
            <h1>Edit Order #<?php echo $order['id']; ?></h1>
            
            <form method="POST" class="add-form">
                <div class="form-group">
                    <label>Order Status</label>
                    <select name="status">
                        <option value="pending" <?php if($order['status']=='pending') echo 'selected'; ?>>Pending</option>
                        <option value="processing" <?php if($order['status']=='processing') echo 'selected'; ?>>Processing</option>
                        <option value="completed" <?php if($order['status']=='completed') echo 'selected'; ?>>Completed</option>
                        <option value="cancelled" <?php if($order['status']=='cancelled') echo 'selected'; ?>>Cancelled</option>
                    </select>
                </div>
                
                <button type="submit">Update Status</button>
                <a href="view.php?id=<?php echo $order['id']; ?>" class="btn-cancel">Cancel</a>
            </form>
        </main>
    </div>
</body>
</html>