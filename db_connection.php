<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "buysensecrm";

// Создаем подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение на наличие ошибок
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
