<?php
// config.php

// 数据库连接
$con = new mysqli("mini-shop-db.cjik4kuws1bw.ap-northeast-1.rds.amazonaws.com", 
    "admin", 
    "ab960204", 
    "mini_shop",
    3306);
if ($con->connect_error) {
    echo json_encode(["status" => "error", "message" => "数据库连接失败: " . $con->connect_error]);
    exit;
}

?>
