<?php
define('DB_HOST', 'hopper.proxy.rlwy.net');
define('DB_USER', 'root');
define('DB_PASS', 'xIOSANZNTFGLAuaXXesijWQsbLiDiTmO');
define('DB_NAME', 'railway');
define('DB_PORT', 21728);

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
?>
