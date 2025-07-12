<?php
// config.php

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'mini_user');
define('DB_PASS', 'ab960204');
define('DB_NAME', 'mini_shop');

// 连接数据库
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
?>
