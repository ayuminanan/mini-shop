<?php
// ======== 跨域头部配置（必须放最前面）========
$allowed_origin = "https://mini-shop-9y8k.onrender.com"; 
if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] === $allowed_origin) {
    header("Access-Control-Allow-Origin: $allowed_origin");
    header("Access-Control-Allow-Credentials: true");
}

header("Content-Type: application/json");

// ======== 预检请求处理 ========
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// ======== 确保 session 跨域一致 ========
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'domain' => 'mini-shop-9y8k.onrender.com',
  'secure' => true,
  'httponly' => true,
  'samesite' => 'None'
]);
session_start();

require_once 'config.php';

// 调试：输出请求来源和session信息
error_log("HTTP_ORIGIN: " . ($_SERVER['HTTP_ORIGIN'] ?? 'null'));
error_log("Session ID: " . session_id());
error_log("Session Data: " . print_r($_SESSION, true));

// ======= 登录验证 =======
if (!isset($_SESSION['id'])) {
    error_log("未登录，SESSION['id']不存在");
    echo json_encode(["error" => "unauthorized"]);
    exit;
}

$user_id = $_SESSION['id'];
error_log("当前用户ID: " . $user_id);

// ======= 查询购物车 =======
$stmt = $con->prepare("SELECT product_id, product_name, product_price, image_url, quantity FROM cart WHERE user_id = ?");
if (!$stmt) {
    error_log("SQL准备失败: " . $con->error);
    echo json_encode(["error" => "db_prepare_failed"]);
    exit;
}

$stmt->bind_param("i", $user_id);
$exec = $stmt->execute();
if (!$exec) {
    error_log("SQL执行失败: " . $stmt->error);
    echo json_encode(["error" => "db_execute_failed"]);
    exit;
}

$result = $stmt->get_result();

$cart = [];
while ($row = $result->fetch_assoc()) {
    $cart[] = [
        "id" => $row['product_id'],
        "name" => $row['product_name'],
        "price" => (float)$row['product_price'],
        "quantity" => (int)$row['quantity'],
        "image_url" => $row['image_url']
    ];
}

error_log("购物车数据: " . print_r($cart, true));

echo json_encode($cart);
