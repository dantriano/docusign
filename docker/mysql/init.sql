show databases;
CREATE DATABASE IF NOT EXISTS laravel;
CREATE USER  IF NOT EXISTS 'laravel'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON laravel.* TO 'laravel'@'%';
FLUSH PRIVILEGES;