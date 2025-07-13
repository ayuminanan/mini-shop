<?php
session_start();

// 数据库连接
require_once 'config.php';

// 临时调试用（正式环境请删除）
$_SESSION['id'] = 1;

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "unauthorized"]);
    exit;
}

$user_email = $_SESSION['id'];


// 1. 获取购物车内容
$cart_sql = "SELECT product_id, product_name, product_price, quantity FROM cart WHERE user_id = ?";
$stmt = mysqli_prepare($con, $cart_sql);
mysqli_stmt_bind_param($stmt, "s", $user_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
}
mysqli_stmt_close($stmt);

if (empty($items)) {
    echo json_encode(["error" => "cart_empty"]);
    mysqli_close($con);
    exit;
}

// 2. 插入订单表
$order_sql = "INSERT INTO orders (user_id, order_date) VALUES (?, NOW())";
$stmt = mysqli_prepare($con, $order_sql);
mysqli_stmt_bind_param($stmt, "s", $user_email);
mysqli_stmt_execute($stmt);
$order_id = mysqli_insert_id($con);
mysqli_stmt_close($stmt);

// 3. 插入订单明细
$order_item_sql = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($con, $order_item_sql);

foreach ($items as $item) {
    mysqli_stmt_bind_param($stmt, "iisid", $order_id, $item['product_id'], $item['product_name'], $item['quantity'], $item['product_price']);
    mysqli_stmt_execute($stmt);
}
mysqli_stmt_close($stmt);

// 4. 清空购物车
$clear_sql = "DELETE FROM cart WHERE user_id = ?";
$stmt = mysqli_prepare($con, $clear_sql);
mysqli_stmt_bind_param($stmt, "s", $user_email);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($con);

// 5. 返回成功
echo json_encode(["success" => true, "order_id" => $order_id]);
?>
