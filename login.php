<?php
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
header("Content-Type: text/plain; charset=utf-8");

require_once 'config.php';
mysqli_set_charset($con, "utf8mb4");

// 获取 POST 数据（加上基本验证）
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo "メールアドレスまたはパスワードを入力してください";
    exit;
}

// 使用预处理查询
$stmt = $con->prepare("SELECT id, username, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    // 如果你将密码用 password_hash 存储，就用 password_verify 检查：
    // if (password_verify($password, $row['password'])) {
    if ($password === $row['password']) {  // 如果是明文对比（不推荐）
        $_SESSION["id"] = $row['id'];
        $_SESSION["username"] = $row['username'];
        echo "success";
    } else {
        echo "メールアドレスまたはパスワードが違います";
    }
} else {
    echo "メールアドレスまたはパスワードが違います";
}
?>
