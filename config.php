<?php
// config.php - 自动判断使用本地还是 Railway 连接

$use_local = true; // 设置为 false 使用 Railway

if ($use_local) {
    $con = new mysqli("localhost", "root", "ab960204", "mini_shop");
} else {
    $con = new mysqli("hopper.proxy.rlwy.net", "root", "xIOSANZNTFGLAuaXXesijWQsbLiDiTmO", "mini_shop", 21728);
}

// 检查连接
if ($con->connect_error) {
    echo json_encode(["status" => "error", "message" => "数据库连接失败: " . $con->connect_error]);
    exit;
}
?>
