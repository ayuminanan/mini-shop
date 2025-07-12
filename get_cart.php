<?php
session_start();

// ======= 临时测试用（部署前请删除）=======
$_SESSION['user_id'] = 1;

// 1. 检查是否已登录
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "unauthorized"]);
    exit;
}

// 2. 获取用户 ID
$user_id = $_SESSION['user_id'];

// 3. 连接数据库
require_once 'config.php';

// 4. 查询购物车
$stmt = $con->prepare("SELECT product_id, product_name, product_price, image_url, quantity FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// 5. 构建 JSON 返回值
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
