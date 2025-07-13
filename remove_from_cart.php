<?php
session_start();

// 数据库连接
require_once 'config.php';

// 临时调用
$_SESSION['id'] = 1;

// 1. 判断是否登录
if(!isset($_SESSION['id'])) {
    echo json_encode(["error" => "unauthorized"]);
    exit;
}

// 2.获取用户邮箱
$user_email = $_SESSION['id'];

// 3. 获取 POST 数据
$data = json_decode(file_get_contents('php://input'),true);
$product_id = $data['product_id'] ?? null;

if(!$product_id){
    echo json_encode(["error" => "missing_product_id"]);
    exit;
}


$stmt = mysqli_prepare($con, "DELETE FROM cart WHERE user_id = ? AND product_id = ?");
mysqli_stmt_bind_param($stmt,"si",$user_email,$product_id);
$succes = mysqli_stmt_execute($stmt);

if($succes){
    echo json_encode(["success" => true]);
}else{
    echo json_encode(["error" => "delete_failed"]);
}

?>