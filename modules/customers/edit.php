<?php
require_once '../../includes/session.php';
require_once '../../includes/functions.php';

$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $company = $_POST['company'];
    
    $sql = "UPDATE customers SET name='$name', email='$email', phone='$phone', address='$address', company='$company' WHERE id=$id";
    $pdo->exec($sql);
    
    header("Location: list.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM customers WHERE id=$id");
$customer = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <h2>CRM System</h2>
            <ul>
                <li><a href="../../dashboard.php">Dashboard</a></li>
                <li><a href="list.php">Customers</a></li>
                <li><a href="../products/list.php">Products</a></li>
                <li><a href="../orders/list.php">Orders</a></li>
                <li><a href="../../logout.php">Logout</a></li>
            </ul>
        </nav>
        
        <main class="content">
            <h1>Edit Customer</h1>
            <form method="POST" class="add-form">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo $customer['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $customer['email']; ?>">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo $customer['phone']; ?>">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address"><?php echo $customer['address']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Company</label>
                    <input type="text" name="company" value="<?php echo $customer['company']; ?>">
                </div>
                <button type="submit">Update Customer</button>
                <a href="list.php" class="btn-cancel">Cancel</a>
            </form>
        </main>
    </div>
</body>
</html>