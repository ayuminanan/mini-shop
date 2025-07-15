<?php
// config.php

// 数据库连接
$con = new mysqli("localhost", "root", "ab960204", "mini_shop");
if ($con->connect_error) {
    echo json_encode(["status" => "error", "message" => "数据库连接失败: " . $con->connect_error]);
    exit;
}

?>
