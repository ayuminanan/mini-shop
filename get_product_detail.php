<?php
// ===== 跨域配置（必须在 session_start 和任何输出之前）=====
$allowed_origin = "https://mini-shop-9y8k.onrender.com"; 
if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] === $allowed_origin) {
    header("Access-Control-Allow-Origin: $allowed_origin");
    header("Access-Control-Allow-Credentials: true");
}
header("Content-Type: application/json");

// OPTIONS 请求直接返回
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

session_start();
require_once 'config.php';

// 安全获取 ID 参数
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo json_encode(["error" => "無効な商品ID"]);
    exit();
}

// 使用预处理语句，防止 SQL 注入
$stmt = $con->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $row['image_url'] = './' . $row['image_url'];
    echo json_encode($row, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["error" => "該当商品が見つかりません"]);
}

$con->close();
?>
