<?php
session_start();

$con = mysqli_connect("localhost", "root", "ab960204", "mini_shop");

if (mysqli_connect_errno()) {
    echo "データベースに接続できません";
    exit();
}

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
