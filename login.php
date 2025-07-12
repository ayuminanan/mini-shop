<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$con = mysqli_connect("localhost", "mini_user", "password123", "mini_shop");
if (mysqli_connect_errno()) {
    echo "DB接続エラー";
    exit;
}

// 验证用户是否存在
$res = mysqli_query($con, "select * from users where email='$email' and password='$password'");
if ($res && mysqli_num_rows($res) > 0){
    $row = mysqli_fetch_assoc($res);
    $_SESSION["id"] = $row['id'];
    $_SESSION["username"] = $row['username'];
    echo "success";
} else {
    echo "メールアドレスまたはパスワードが違います";
}

?>