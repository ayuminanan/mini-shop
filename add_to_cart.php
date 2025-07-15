<?php
session_start();

// 数据库连接
require_once 'config.php';

// 获取用户 ID
if (!isset($_SESSION['id'])) {
    echo json_encode(["status" => "error", "message" => "未登录，无法添加到购物车"]);
    exit;
}
$user_id = $_SESSION['id'];

// 获取 POST 参数
$product_id   = $_POST['id'];
$product_name = $_POST['name'];
$product_price = $_POST['price'] ?? null;
$quantity     = $_POST['quantity'] ?? 1;
$image_url    = $_POST['image_url'] ?? null;

// 参数检查
if (!$product_id || !$product_name || !$product_price) {
    echo json_encode(["status" => "error", "message" => "缺少必要参数"]);
    exit;
}

// 检查是否已存在该商品
$checkStmt = $con->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
$checkStmt->bind_param("ii", $user_id, $product_id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    // 更新商品数量
    $row = $result->fetch_assoc();
    $new_quantity = $row['quantity'] + $quantity;

    $updateStmt = $con->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $updateStmt->bind_param("iii", $new_quantity, $user_id, $product_id);

    if ($updateStmt->execute()) {
        echo json_encode(["status" => "success", "message" => "商品数量已更新"]);
    } else {
        echo json_encode(["status" => "error", "message" => "更新失败：" . $updateStmt->error]);
    }
} else {
    // 插入新商品
    $insertStmt = $con->prepare("INSERT INTO cart (user_id, product_id, product_name, product_price, quantity, image_url) VALUES (?, ?, ?, ?, ?, ?)");
    $insertStmt->bind_param("iisdis", $user_id, $product_id, $product_name, $product_price, $quantity, $image_url);

    if ($insertStmt->execute()) {
        echo json_encode(["status" => "success", "message" => "商品已添加到购物车"]);
    } else {
        echo json_encode(["status" => "error", "message" => "添加失败：" . $insertStmt->error]);
    }
}

$con->close();
?>
