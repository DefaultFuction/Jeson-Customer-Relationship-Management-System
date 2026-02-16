<?php
require_once '../../includes/session.php';

$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    
    $sql = "UPDATE products SET name='$name', description='$description', price='$price', stock='$stock' WHERE id=$id";
    $pdo->exec($sql);
    
    header("Location: list.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM products WHERE id=$id");
$product = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
            <h1>Edit Product</h1>
            <form method="POST" class="add-form">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4"><?php echo $product['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Price ($)</label>
                    <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" name="stock" value="<?php echo $product['stock']; ?>">
                </div>
                <button type="submit">Update Product</button>
                <a href="list.php" class="btn-cancel">Cancel</a>
            </form>
        </main>
    </div>
</body>
</html>