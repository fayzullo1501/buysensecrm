-- Создание базы данных
CREATE DATABASE IF NOT EXISTS buysensecrm;
USE buysensecrm;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Таблица товаров
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NULL,
    description TEXT NULL,
    price DECIMAL(10, 2) NULL,
    costprice DECIMAL(10, 2) NULL, -- Добавлено поле "costprice"
    image VARCHAR(255),
    quantity INT NULL,
    seller VARCHAR(255),
    phone VARCHAR(20)
);

-- Таблица клиентов
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fio VARCHAR(255) NOT NULL,
    purchase_name TEXT,
    purchase_code VARCHAR(255),
    address TEXT,
    phone VARCHAR(20)
);

-- Вставка данных по умолчанию в таблицу пользователей
INSERT INTO users (email, password) VALUES ('admin@gmail.com', 'admin123');
INSERT INTO users (email, password) VALUES ('abdumalik@buysense.uz', '998812610');
INSERT INTO users (email, password) VALUES ('fayzullo@buysense.uz', 'fayzullo1501');
