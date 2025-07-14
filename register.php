<?php
// 设置安全的session cookie参数
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => 'mini-shop-9y8k.onrender.com', 
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax' 
]);
session_start();

header("Access-Control-Allow-Origin: https://mini-shop-9y8k.onrender.com");
header("Access-Control-Allow-Credentials: true");

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

require_once 'config.php';

// 简单SQL注入防护建议用预处理，以下仅示例保持结构
$email = mysqli_real_escape_string($con, $email);
$username = mysqli_real_escape_string($con, $username);
$password = mysqli_real_escape_string($con, $password);

$res = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");

if ($res) {
    $row = mysqli_fetch_assoc($res);
    if ($row != null) {
        $_SESSION["id"] = $row['id'];
        $_SESSION["username"] = $row['username'];
        echo "exists_login";
    } else {
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
