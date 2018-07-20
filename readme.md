Tic-Tac-Toe Game

Requirements
1. PHP (versions PHP >= 7.1.3)
2. OpenSSL PHP Extension
3. PDO PHP Extension
4. Mbstring PHP Extension
5. Tokenizer PHP Extension
6. XML PHP Extension
7. Ctype PHP Extension
8. JSON PHP Extension
4. Composer
5. Enabled mod_rewrite on your server

Installing
1. git clone https://github.com/MarijaDjordjevic/Backend.git
2. sudo cp .env.example .env
3. create new database and set up database credentials in .env file
4. composer install
5. php artisan key:generate
6. php artisan migrate
7. php artisan serve

Implemented functionalities:
1. Register and login system based on JWT Authentication