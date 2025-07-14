<?php
// === 跨域支持设置 ===
header("Access-Control-Allow-Origin: https://mini-shop-frontend.onrender.com"); // ← 替换为你前端的实际地址
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// 预检请求直接返回
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

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
