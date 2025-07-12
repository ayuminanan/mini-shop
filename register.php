<?php
session_start();

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

$con = mysqli_connect("localhost", "mini_user", "password123", "mini_shop");

if (mysqli_connect_errno()) {
    echo "データベースに接続できません";
}

// 检查是否已经注册
$res = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");
if ($res) {
    $row = mysqli_fetch_assoc($res);
    if ($row != null) {
        echo "このメールアドレスはすでに登録されています";
    } else {
        $insert = mysqli_query($con, "INSERT INTO users (email, username, password) VALUES ('$email','$username','$password')");
        if ($insert) {
            $_SESSION["id"] = $email;
            echo "success";
        } else {
            echo "登録中にエラーが発生しました";
        }
    }
} else {
    echo "クエリ実行エラー";
}
?>