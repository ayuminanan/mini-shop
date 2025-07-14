<?php
session_start();

// === 设置允许跨域 ===
header("Access-Control-Allow-Origin: https://mini-shop-frontend.onrender.com"); // 请替换为你的前端地址
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// === 如果是预检请求（OPTIONS）则直接返回 200 ===
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// === 检查 session 状态 ===
if (isset($_SESSION["id"]) && isset($_SESSION["username"])) {
    echo json_encode([
        "logged_in" => true,
        "username" => $_SESSION["username"]
    ]);
} else {
    echo json_encode(["logged_in" => false]);
}

