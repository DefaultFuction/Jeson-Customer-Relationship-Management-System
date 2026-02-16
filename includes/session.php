<?php
session_start();
// 使用绝对路径
require_once dirname(__DIR__) . '/config/database.php';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit();
}

if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) != 'index.php') {
    redirect('index.php');
}
?>