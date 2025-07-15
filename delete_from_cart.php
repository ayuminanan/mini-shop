<?php

// 数据库连接
require_once 'config.php';

session_start();

// 获取用户 ID（正式环境应判断登录）
$user_id = $_SESSION['user_id'] ?? 1;

// 获取前端传来的商品 id
$product_id = $_POST['product_id'] ?? null;

// 参数检查
if (!$product_id) {
    echo json_encode(["status" => "error", "message" => "缺少 product_id 参数"]);
    exit;
}

// 执行删除
$deleteStmt = $con->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
$deleteStmt->bind_param("ii", $user_id, $product_id);

if ($deleteStmt->execute()) {
    echo json_encode(["status" => "success", "message" => "商品はカートから削除されました"]);
} else {
    echo json_encode(["status" => "error", "message" => "削除に失敗しました: " . $deleteStmt->error]);
}
?>
