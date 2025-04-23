# PHPイメージをベースにする
FROM php:7.4-apache

# 必要な拡張機能をインストールする
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Apacheの設定を変更（必要に応じて）
# COPY ./my-custom-apache.conf /etc/apache2/sites-available/000-default.conf

# 作業ディレクトリを設定
WORKDIR /var/www/html

# アプリケーションのソースコードをコピー
COPY . /var/www/html

# Apacheを起動
CMD ["apache2-foreground"]
