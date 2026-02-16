<?php
require_once '../../includes/session.php';

$id = $_GET['id'];

$pdo->exec("DELETE FROM order_items WHERE order_id=$id");
$pdo->exec("DELETE FROM orders WHERE id=$id");

header("Location: list.php");
exit();
?>