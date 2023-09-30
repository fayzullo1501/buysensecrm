<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "buysensecrm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Выполните SQL-запрос для удаления клиента по ID
    $query = "DELETE FROM clients WHERE id='$id'";

    if ($conn->query($query) === TRUE) {
        // Успешное удаление
        echo "Клиент успешно удален.";
    } else {
        echo "Ошибка при удалении клиента: " . $conn->error;
    }
}

$conn->close();
?>
