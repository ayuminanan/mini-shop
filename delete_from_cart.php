<?php

// 数据库连接
require_once 'config.php';

session_start();

$_SESSION['user_id'] = 1;

// 假设 user_id 从 session 获取，测试时默认 1
$user_id = $_SESSION['user_id'] ?? 1;

// 获取前端传来的商品 id
$product_id = $_POST['product_id'] ?? null;

// 参数检查
if (!$product_id) {
    echo json_encode(["status" => "error", "message" => "缺少 product_id 参数"]);
    exit;
}

// 削除を実行
$deleteStmt = $con->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
$deleteStmt->bind_param("ii",$user_id, $product_id);

if ($deleteStmt->execute()) {
    echo json_encode(["status" => "success", "message" => "商品はカートから削除されました"]);
} else {
    echo json_encode(["status" => "error", "message" => "削除に失敗しました: " . $deleteStmt->error]);
}

?>