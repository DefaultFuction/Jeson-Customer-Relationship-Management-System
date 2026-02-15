<?php
require_once '../../includes/session.php';

$customers = $pdo->query("SELECT id, name FROM customers ORDER BY name")->fetchAll();
$products = $pdo->query("SELECT id, name, price, stock FROM products WHERE stock > 0")->fetchAll();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $product_ids = $_POST['product_id'];
    $quantities = $_POST['quantity'];
    $total = 0;
    
    $pdo->beginTransaction();
    
    try {
        $orderSql = "INSERT INTO orders (customer_id, total_amount) VALUES (?, 0)";
        $orderStmt = $pdo->prepare($orderSql);
        $orderStmt->execute([$customer_id]);
        $order_id = $pdo->lastInsertId();
        
        for($i = 0; $i < count($product_ids); $i++) {
            $product_id = $product_ids[$i];
            $quantity = $quantities[$i];
            
            $productStmt = $pdo->prepare("SELECT price, stock FROM products WHERE id = ?");
            $productStmt->execute([$product_id]);
            $product = $productStmt->fetch();
            
            $itemTotal = $product['price'] * $quantity;
            $total += $itemTotal;
            
            $itemSql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $itemStmt = $pdo->prepare($itemSql);
            $itemStmt->execute([$order_id, $product_id, $quantity, $product['price']]);
            
            $updateStock = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            $updateStock->execute([$quantity, $product_id]);
        }
        
        $updateOrder = $pdo->prepare("UPDATE orders SET total_amount = ? WHERE id = ?");
        $updateOrder->execute([$total, $order_id]);
        
        $pdo->commit();
        
        $backupCommand = "echo 'New order created: $order_id' >> /var/log/crm_orders.log";
        executeSystemCommand($backupCommand);
        
        header("Location: list.php");
        exit();
        
    } catch(Exception $e) {
        $pdo->rollBack();
        $error = "Error creating order: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script src="../../assets/js/main.js"></script>
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
            <h1>Create New Order</h1>
            
            <?php if(isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" id="orderForm">
                <div class="form-group">
                    <label>Select Customer</label>
                    <select name="customer_id" required>
                        <option value="">Choose a customer</option>
                        <?php foreach($customers as $customer): ?>
                        <option value="<?php echo $customer['id']; ?>">
                            <?php echo $customer['name']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div id="orderItems">
                    <div class="order-item">
                        <h3>Item 1</h3>
                        <div class="form-group">
                            <label>Product</label>
                            <select name="product_id[]" class="product-select" required>
                                <option value="">Select product</option>
                                <?php foreach($products as $product): ?>
                                <option value="<?php echo $product['id']; ?>" 
                                        data-price="<?php echo $product['price']; ?>"
                                        data-stock="<?php echo $product['stock']; ?>">
                                    <?php echo $product['name']; ?> - $<?php echo $product['price']; ?> 
                                    (Stock: <?php echo $product['stock']; ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" name="quantity[]" class="quantity" min="1" value="1" required>
                        </div>
                    </div>
                </div>
                
                <button type="button" onclick="addOrderItem()">Add Another Item</button>
                <button type="submit">Create Order</button>
                <a href="list.php" class="btn-cancel">Cancel</a>
            </form>
        </main>
    </div>
</body>
</html>