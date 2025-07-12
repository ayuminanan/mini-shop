<?php

session_start();

// 测试用：假设 user_id 从 session 获取
$_SESSION['user_id'] = 1;
$user_id = $_SESSION['user_id'] ?? 1;

// 获取前端传来的参数
$product_id = $_POST['product_id'] ?? null;
$quantity = $_POST['quantity'] ?? null;

// 参数检查
if (!$product_id || !$quantity || !is_numeric($quantity) || $quantity <= 0) {
    echo json_encode(["status" => "error", "message" => "無効な product_id または quantity" ]);
    exit;
}

// 数据库连接
$con = new mysqli("localhost", "mini_user", "password123", "mini_shop");
if ($con->connect_error) {
    echo json_encode(["status" => "error", "message" => "数据库连接失败: " . $con->connect_error]);
    exit;
}

// 更新处理
$updateStmt = $con->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
$updateStmt->bind_param("iii",$quantity, $user_id, $product_id);

if ($updateStmt->execute()) {
    echo json_encode(["status" => "success", "message" => "数量が正常に更新されました"]);
} else {
    echo json_encode(["status" => "error", "message" => "更新に失敗しました: " . $updateStmt->error]);
}

?>
