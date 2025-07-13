<?php
// config.php

define('DB_HOST', 'hopper.proxy.rlwy.net'); // RAILWAY_TCP_PROXY_DOMAIN 的值
define('DB_PORT', 21728);                   // RAILWAY_TCP_PROXY_PORT 的值（需查看 Railway 控制台的 Connect 页）
define('DB_USER', 'root');
define('DB_PASS', 'xIOSANZNTFGLAuaXXesijWQsbLiDiTmO');
define('DB_NAME', 'mini_shop');

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// 检查连接
if ($con->connect_error) {
    die("连接失败: " . $con->connect_error);
}
?>
