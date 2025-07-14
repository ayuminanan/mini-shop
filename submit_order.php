<?php
header("Content-Type: application/json");
session_start();
require_once 'config.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "未登录"]);
    exit;
}

$user_id = $_SESSION['id'];

// 获取购物车
$cart_sql = "SELECT product_id, product_price, quantity FROM cart WHERE user_id = ?";
$stmt = $con->prepare($cart_sql);
if (!$stmt) {
    echo json_encode(["error" => "购物车查询失败", "mysql_error" => $con->error]);
    exit;
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $total += $row['product_price'] * $row['quantity'];
}
$stmt->close();

if (empty($items)) {
    echo json_encode(["error" => "购物车为空"]);
    $con->close();
    exit;
}

// 插入订单主表
$order_sql = "INSERT INTO orders (user_id, total) VALUES (?, ?)";
$stmt = $con->prepare($order_sql);
if (!$stmt) {
    echo json_encode(["error" => "订单插入失败", "mysql_error" => $con->error]);
    $con->close();
    exit;
}
$stmt->bind_param("id", $user_id, $total);
if (!$stmt->execute()) {
    echo json_encode(["error" => "订单插入失败", "mysql_error" => $stmt->error]);
    $stmt->close();
    $con->close();
    exit;
}
$order_id = $con->insert_id;
$stmt->close();

// 插入订单明细（不含 product_name）
$order_item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
$stmt = $con->prepare($order_item_sql);
if (!$stmt) {
    echo json_encode(["error" => "订单明细插入失败", "mysql_error" => $con->error]);
    $con->close();
    exit;
}
foreach ($items as $item) {
    $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['product_price']);
    if (!$stmt->execute()) {
        echo json_encode(["error" => "订单明细插入失败", "mysql_error" => $stmt->error]);
        $stmt->close();
        $con->close();
        exit;
    }
}
$stmt->close();

// 清空购物车
$clear_sql = "DELETE FROM cart WHERE user_id = ?";
$stmt = $con->prepare($clear_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

// 返回成功
$con->close();
echo json_encode(["success" => true, "order_id" => $order_id]);
?>
