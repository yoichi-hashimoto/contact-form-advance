# お問い合わせフォーム
## 環境構築
    1.git clone https://github.com/yoichi-hashimoto/contact-form-advance.git
    2.docker-compose up -d --build
    ※MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせてdocker-compose.ymlファイルを準備してください。

## Laravel環境構築
    1.docker-compose exec php bash
    2.composer install
    3..env.exampleファイルから.envを作成し、環境変数を変更
    4.php artisan key:generate
    5.php artisan migrate
    6.php artisan db:seed

## 使用技術
    ・PHP 8.2.27
    ・Laravel 8.83.8
    ・MySQL 8.0.26
    ・Webサーバー Nginx

## ER図
    ![ER図](https://github.com/yoichi-hashimoto/contact-form-advance/blob/b5cc387b2f1692873d2c9d8a6c7204b13f890c81/src/public/images/er_FashonablyLate.drawio.png)

## URL
    ・開発環境:http://localhost/
    ・phpMyAdmin:http://localhost:8080/
