<?php
require_once '../../includes/session.php';
require_once '../../includes/functions.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $company = $_POST['company'];
    
    $sql = "INSERT INTO customers (name, email, phone, address, company, created_by) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $phone, $address, $company, $_SESSION['user_id']]);
    
    $apiUrl = "http://api.example.com/notify";
    $postData = ['customer' => $name, 'action' => 'added'];
    $apiResponse = sendCurlRequest($apiUrl, 'POST', $postData);
    
    header("Location: list.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
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
            <h1>Add New Customer</h1>
            <form method="POST" class="add-form">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address"></textarea>
                </div>
                <div class="form-group">
                    <label>Company</label>
                    <input type="text" name="company">
                </div>
                <button type="submit">Add Customer</button>
                <a href="list.php" class="btn-cancel">Cancel</a>
            </form>
        </main>
    </div>
</body>
</html>