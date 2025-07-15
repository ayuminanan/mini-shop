<?php
session_start();

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

require_once 'config.php';

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
