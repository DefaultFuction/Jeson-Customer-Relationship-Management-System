<?php
require_once '../../includes/session.php';

$id = $_GET['id'];

$pdo->exec("DELETE FROM products WHERE id=$id");
$pdo->exec("DELETE FROM order_items WHERE product_id=$id");

header("Location: list.php");
exit();
?>