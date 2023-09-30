<?php
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Создаем новый объект таблицы Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Заголовки столбцов
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Название');
$sheet->setCellValue('C1', 'Описание');
$sheet->setCellValue('D1', 'Цена');
$sheet->setCellValue('E1', 'Количество');
$sheet->setCellValue('F1', 'Диллер');
$sheet->setCellValue('G1', 'Себестоимость');
$sheet->setCellValue('H1', 'Телефон');

// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "buysensecrm";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Выборка данных из базы данных
$query = "SELECT * FROM products";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $rowNumber = 2; // Начало данных со второй строки
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row['id']);
        $sheet->setCellValue('B' . $rowNumber, $row['name']);
        $sheet->setCellValue('C' . $rowNumber, $row['description']);
        $sheet->setCellValue('D' . $rowNumber, $row['price']);
        $sheet->setCellValue('E' . $rowNumber, $row['quantity']);
        $sheet->setCellValue('F' . $rowNumber, $row['seller']);
        $sheet->setCellValue('G' . $rowNumber, $row['costprice']);
        $sheet->setCellValue('H' . $rowNumber, $row['phone']);
        $rowNumber++;
    }
}

// Создаем объект Writer для сохранения в файл
$writer = new Xlsx($spreadsheet);

// Устанавливаем заголовки для HTTP-ответа
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="products.xlsx"');

// Выводим содержимое файла в выходной поток
$writer->save('php://output');
