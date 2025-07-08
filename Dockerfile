# 使用官方 PHP 8.1 带 Apache 的基础镜像
FROM php:8.1-apache

# 复制当前目录下所有文件到容器的网页根目录
COPY . /var/www/html/

# 启用 Apache 的 rewrite 模块（常用伪静态支持）
RUN a2enmod rewrite
