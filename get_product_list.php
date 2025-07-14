<?php
// ===== 跨域配置（必须在 session_start 和任何输出之前）=====
$allowed_origin = "https://mini-shop-9y8k.onrender.com";
if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] === $allowed_origin) {
    header("Access-Control-Allow-Origin: $allowed_origin");
    header("Access-Control-Allow-Credentials: true");
}
header('Content-Type: application/json; charset=utf-8');

// OPTIONS 请求直接返回（某些框架需要这个预检响应）
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

session_start();
require_once 'config.php';

$result = mysqli_query($con, "SELECT * FROM products");

if ($result) {
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['image_url'] = './' . $row['image_url']; // 相对路径修正
        $products[] = $row;
    }
    echo json_encode($products, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["error" => "商品データの取得に失敗しました"]);
}
?>
