<?php
require_once 'config.php';

if(!$con){
    echo json_encode(["error" => "データベース接続失敗"]);
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']):0;

if($id <= 0){
    echo json_encode(["error" => "無効な商品ID"]);
    exit();
}

$result = mysqli_query($con,"SELECT * FROM products WHERE id = $id");

if($row = mysqli_fetch_assoc($result)){
    $row['image_url'] = './' . $row['image_url'];
    echo json_encode($row,JSON_UNESCAPED_UNICODE);
}else{
    echo json_encode(["error" => "該当商品が見つかりません"]);
}

?>