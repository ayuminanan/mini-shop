<?php
session_start();

// 清除所有会话变量
$_SESSION = [];

// 销毁会话
session_destroy();

// 清除客户端缓存，确保浏览器不缓存登出状态
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// 跳转到登录页面
header("Location: login.html");
exit;
