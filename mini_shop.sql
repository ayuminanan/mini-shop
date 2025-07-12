/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80016
 Source Host           : localhost:3306
 Source Schema         : mini_shop

 Target Server Type    : MySQL
 Target Server Version : 80016
 File Encoding         : 65001

 Date: 12/07/2025 00:04:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cart
-- ----------------------------
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for cart_items
-- ----------------------------
DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_cart_user` (`user_id`),
  KEY `fk_cart_product` (`product_id`),
  CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for order_items
-- ----------------------------
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_orderitem_order` (`order_id`),
  KEY `fk_orderitem_product` (`product_id`),
  CONSTRAINT `fk_orderitem_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_orderitem_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of orders
-- ----------------------------
BEGIN;
INSERT INTO `orders` VALUES (51, NULL, NULL, 'pending', '2025-05-29 21:35:31');
COMMIT;

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `stock` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_recommended` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of products
-- ----------------------------
BEGIN;
INSERT INTO `products` VALUES (1, 'アップルジュース', 300.00, 'images/apple_juice.jpg', '100% 青森りんごジュース', 10, '2025-06-01 20:42:41', 1);
INSERT INTO `products` VALUES (2, 'チョコレート', 150.00, 'images/chocolate.jpg', 'ビターチョコレート', 20, '2025-06-01 20:42:41', 2);
INSERT INTO `products` VALUES (3, '抹茶クッキー', 250.00, 'images/matcha_cookie.jpg', '宇治抹茶使用', 15, '2025-06-01 20:42:41', 3);
INSERT INTO `products` VALUES (4, '和風せんべい', 180.00, 'images/senbei.jpg', '伝統的な和風おせんべい', 25, '2025-06-01 20:42:41', 4);
INSERT INTO `products` VALUES (5, 'ほうじ茶', 400.00, 'images/hojicha.jpg', '香ばしい焙じ茶パック', 30, '2025-06-01 20:42:41', 5);
INSERT INTO `products` VALUES (6, '桜餅', 220.00, 'images/sakuramochi.jpg', '春限定の桜の葉包み餅', 18, '2025-06-01 20:42:41', 6);
INSERT INTO `products` VALUES (7, '柚子はちみつ', 500.00, 'images/yuzu_honey.jpg', '柚子果汁入りのはちみつ', 12, '2025-06-01 20:42:41', 7);
INSERT INTO `products` VALUES (8, '抹茶ラテ', 350.00, 'images/matcha_latte.jpg', 'まろやかな抹茶ラテ', 20, '2025-06-01 20:42:41', 8);
INSERT INTO `products` VALUES (9, 'たこ焼きセット', 600.00, 'images/takoyaki.jpg', '自宅で作れるたこ焼きセット', 10, '2025-06-01 20:42:41', 9);
INSERT INTO `products` VALUES (10, '梅干し', 300.00, 'images/umeboshi.jpg', '昔ながらの塩漬け梅干し', 22, '2025-06-01 20:42:41', 10);
INSERT INTO `products` VALUES (11, 'みたらし団子', 280.00, 'images/mitarashi.jpg', '甘辛い醤油ダレのみたらし団子', 15, '2025-06-01 20:42:41', 11);
INSERT INTO `products` VALUES (12, '黒ごまプリン', 320.00, 'images/kurogoma_pudding.jpg', '濃厚な黒ごまプリン', 14, '2025-06-01 20:42:41', 12);
INSERT INTO `products` VALUES (13, '抹茶アイスクリーム', 450.00, 'images/matcha_ice.jpg', '濃厚抹茶味のアイスクリーム', 25, '2025-06-01 20:42:41', 13);
INSERT INTO `products` VALUES (14, 'きなこ餅', 210.00, 'images/kinako_mochi.jpg', '香ばしいきな粉餅', 30, '2025-06-01 20:42:41', 14);
INSERT INTO `products` VALUES (15, '日本酒（720ml）', 1800.00, 'images/sake.jpg', '地元産の吟醸酒', 8, '2025-06-01 20:42:41', 15);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (2, 'alice', 'password123', 'alice@example.com', 'user');
INSERT INTO `users` VALUES (3, 'bob', 'securepass', 'bob@example.com', 'admin');
INSERT INTO `users` VALUES (4, 'charlie', 'charlie123', 'charlie@example.com', 'user');
INSERT INTO `users` VALUES (5, 'dave', 'davepass456', 'dave@example.com', 'user');
INSERT INTO `users` VALUES (6, 'eve', 'evesecret', 'eve@example.com', 'admin');
INSERT INTO `users` VALUES (7, 'frank', 'frankpwd', 'frank@example.com', 'user');
INSERT INTO `users` VALUES (8, '水树奈奈', 'Ab960204', 'j597512718@gmail.com', 'user');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
