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

// ======= 登录验证 =======
if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "unauthorized"]);
    exit;
}

$user_id = $_SESSION['id'];

// ======= 查询购物车 =======
$stmt = $con->prepare("SELECT product_id, product_name, product_price, image_url, quantity FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
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

echo json_encode($cart);
?>
