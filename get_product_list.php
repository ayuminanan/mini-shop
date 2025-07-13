<?php
session_start();

// 数据库连接
require_once 'config.php';

$result = mysqli_query($con, "SELECT * FROM products");

if ($result) {
    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $row['image_url'] = './' . $row['image_url']; // 相对路径修正
        $products[] = $row;
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($products, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["error" => "商品データの取得に失敗しました"]);
}
?>
