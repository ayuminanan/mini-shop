<?php
session_start();

// 连接数据库
$con = new mysqli("localhost", "mini_user", "password123", "mini_shop");
if($con->connect_error){
    echo json_encode(["status" => "error", "message" => "数据库连接失败: " . $con->connect_error]);
    exit;
}

// 查询推荐商品(最多6个)
$sql = "SELECT id, name, price, description, image_url 
        FROM products 
        WHERE is_recommended > 0 
        ORDER BY is_recommended ASC 
        LIMIT 6";
$result = $con->query($sql);

$products = [];

if($result && $result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
        $products[] = $row;
    }

    echo json_encode([
        "status" => "success",
        "data" => $products
    ]);
} else {
    echo json_encode([
        "status" => "success",
        "data" => [],
        "message" => "没有推荐商品"
    ]);
}

?>