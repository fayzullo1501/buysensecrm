<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
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

if (isset($_POST['import'])) {
    // Обработка загруженного Excel-файла
    if ($_FILES['file']['name']) {
        $fileName = $_FILES['file']['name'];
        $filePath = $_FILES['file']['tmp_name'];

        // Подключение библиотеки для работы с Excel
        require_once 'vendor/autoload.php'; // Подключаем автозагрузчик Composer

        try {
            // Загрузка Excel-файла
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();

            // Начало транзакции
            $conn->begin_transaction();

            for ($row = 2; $row <= $highestRow; $row++) {
                // Получение данных из ячеек Excel
                $name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $description = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $price = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $quantity = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $seller = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $costprice = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                $phone = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

                // Вставка данных в базу данных
                $insertQuery = "INSERT INTO products (name, description, price, quantity, seller, costprice, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param("ssdiiss", $name, $description, $price, $quantity, $seller, $costprice, $phone);
                $stmt->execute();
                $stmt->close();
            }

            // Завершение транзакции
            $conn->commit();

            // Редирект обратно на страницу учета товаров
            header("Location: uchet.php");
            exit();
        } catch (Exception $e) {
            // Ошибка при обработке Excel-файла
            $conn->rollback();
            echo "Ошибка: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Импорт товаров из Excel</title>
    <link rel="stylesheet" href="uchet.css">
</head>
<body>
    <!-- Navigation -->
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h1>Импорт товаров из Excel</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="file" accept=".xls, .xlsx">
            <input type="submit" name="import" value="Импортировать">
        </form>
    </div>
</body>
</html>
