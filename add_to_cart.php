<?php
session_start();

// 获取用户 ID（实际项目中应判断用户是否已登录）
$user_id = $_SESSION['user_id'] ?? 1;

// 获取 POST 参数
$product_id = $_POST['id'] ?? null;
$product_name = $_POST['name'] ?? null;
$product_price = $_POST['price'] ?? null;
$quantity = $_POST['quantity'] ?? 1;
$image_url = $_POST['image_url'] ?? null;

// 参数检查
if (!$product_id || !$product_name || !$product_price) {
    echo json_encode(["status" => "error", "message" => "缺少必要参数"]);
    exit;
}

// 连接数据库
$con = new mysqli("localhost", "root", "ab960204", "mini_shop");
if ($con->connect_error) {
    echo json_encode(["status" => "error", "message" => "数据库连接失败: " . $con->connect_error]);
    exit;
}

// 检查购物车中是否已有该商品
$checkStmt = $con->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
$checkStmt->bind_param("ii", $user_id, $product_id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    // 已存在商品，更新数量
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
    // 新商品，插入记录
    $insertStmt = $con->prepare("INSERT INTO cart (user_id, product_id, product_name, product_price, quantity, image_url) VALUES (?, ?, ?, ?, ?, ?)");
    $insertStmt->bind_param("iisdis", $user_id, $product_id, $product_name, $product_price, $quantity, $image_url);

    if ($insertStmt->execute()) {
        echo json_encode(["status" => "success", "message" => "商品已添加到购物车"]);
    } else {
        echo json_encode(["status" => "error", "message" => "添加失败：" . $insertStmt->error]);
    }
}

// 关闭连接
$con->close();
?>
