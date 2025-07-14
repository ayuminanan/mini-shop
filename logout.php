<?php
session_start();

// 清除所有会话变量
$_SESSION = [];

// 销毁会话
session_destroy();

// 跳转到登录页（或者首页）
header("Location: login.html");
exit;
