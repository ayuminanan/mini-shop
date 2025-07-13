<?php
session_start();

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

require_once 'config.php';

// 查询是否已存在该邮箱
$res = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");

if ($res) {
    $row = mysqli_fetch_assoc($res);
    if ($row != null) {
        // 邮箱已存在，直接登录
        $_SESSION["id"] = $row['id'];
        $_SESSION["username"] = $row['username'];
        echo "exists_login";  // 告诉前端用户已存在，已登录
    } else {
        // 新用户，插入数据库
        $insert = mysqli_query($con, "INSERT INTO users (email, username, password) VALUES ('$email','$username','$password')");
        if ($insert) {
            $_SESSION["id"] = mysqli_insert_id($con);
            $_SESSION["username"] = $username;
            echo "success";
        } else {
            echo "登録中にエラーが発生しました";
        }
    }
} else {
    echo "クエリ実行エラー";
}
?>
