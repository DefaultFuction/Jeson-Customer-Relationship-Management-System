<?php
require_once '../../includes/session.php';

$id = $_GET['id'];

$pdo->exec("DELETE FROM customers WHERE id=$id");
$pdo->exec("DELETE FROM orders WHERE customer_id=$id");

header("Location: list.php");
exit();
?>