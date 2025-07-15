<?php
session_start();

require_once 'config.php';

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
