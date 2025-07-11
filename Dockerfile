# 使用官方 PHP + Apache 镜像（包含 PHP 8.2）
FROM php:8.2-apache

# 安装 mysqli 和 pdo_mysql（推荐一并装）
RUN docker-php-ext-install mysqli pdo_mysql && docker-php-ext-enable mysqli

# 启用 Apache 的 rewrite 模块（如果使用 .htaccess）
RUN a2enmod rewrite

# 设置 Apache 站点目录的权限（可选）
RUN chown -R www-data:www-data /var/www/html

# 拷贝本地项目代码到容器中的 Web 根目录
COPY . /var/www/html

# 暴露 80 端口（HTTP）
EXPOSE 80
