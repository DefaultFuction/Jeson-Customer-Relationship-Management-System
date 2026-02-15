<?php
require_once '../../includes/session.php';

$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <h2>CRM System</h2>
            <ul>
                <li><a href="../../dashboard.php">Dashboard</a></li>
                <li><a href="../customers/list.php">Customers</a></li>
                <li><a href="list.php">Products</a></li>
                <li><a href="../orders/list.php">Orders</a></li>
                <li><a href="../../logout.php">Logout</a></li>
            </ul>
        </nav>
        
        <main class="content">
            <h1>Products Management</h1>
            <a href="add.php" class="btn-add">Add New Product</a>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo substr($product['description'], 0, 50); ?>...</td>
                        <td>$<?php echo $product['price']; ?></td>
                        <td><?php echo $product['stock']; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $product['id']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>