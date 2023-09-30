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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Склад (Учёт товаров)</title>
    <link rel="stylesheet" href="uchet.css">
    <link rel="stylesheet" href="pages.css">
</head>
<body>
    <!-- Navigation -->
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h1>Склад (Учет товаров)</h1>
        <!-- Кнопка для перехода на страницу добавления товара -->
        <div class="action-buttons">
            <a href="./product/add_product.php"><button>Добавить товар</button></a>
        </div>
        <!-- Кнопка для перехода на страницу импорта данных из Excel -->
        <div class="action-buttons">
            <a href="./import.php"><button>Импорт данных из Excel</button></a>
        </div>
        <form action="export.php" method="post" class="import-form">
            <button type="submit" name="export_excel" class="export-button">Экспорт в Excel</button>
        </form><br>
        <!-- Форма для поиска товаров -->
        <div class="search-form">
            <form method="get" action="">
                <input type="text" name="search" placeholder="Поиск товаров">
                <input type="submit" value="Искать">
            </form>
        </div>
        <!-- Таблица для вывода товаров -->
        <table>
            <tr>
                <th>ID</th>
                <th>Название </th>
                <th>Описание</th>
                <th>Цена</th>
                <th>Кол-во</th>
                <th>№ магазина</th>
                <th>Себестоимость</th>
                <th>Телефон</th>
                <th>Действия</th>
            </tr>
            <!-- PHP-код для вывода данных из базы с учетом поискового запроса и пагинации -->
            <?php
            // Определение количества товаров на одной странице
            $itemsPerPage = 7;

            // Получите значение параметра search из GET-запроса
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Запрос на выборку товаров с учетом поискового запроса
            $query = "SELECT COUNT(*) as total FROM products WHERE name LIKE '%$search%'";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            $totalItems = $row['total'];

            // Определение текущей страницы
            $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

            // Рассчитайте общее количество страниц
            $totalPages = ceil($totalItems / $itemsPerPage);

            // Вычисление смещения для запроса
            $offset = ($current_page - 1) * $itemsPerPage;

            // Запрос на выборку товаров с учетом поискового запроса и пагинации
            $query = "SELECT * FROM products WHERE name LIKE '%$search%' LIMIT $itemsPerPage OFFSET $offset";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td>" . number_format($row['price'], 2, '.', ' ') . " Сум</td>
                    <td>" . $row['quantity'] . "</td>
                    <td>" . $row['seller'] . "</td>
                    <td>" . number_format($row['costprice'], 2, '.', ' ') . " Сум</td>
                    <td>" . $row['phone'] . "</td>
                    <td>
                        <a href='./product/edit_product.php?id=" . $row['id'] . "'><button class='edit-button'>Изменить</button></a>
                        <button class='delete-button' onclick=\"confirmDelete(" . $row['id'] . ")\">Удалить</button>
                    </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Товар не найден!</td></tr>";
            }
            ?>
        </table>

        <!-- Кнопки для переключения между страницами -->
        <div class="pagination">
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                $activeClass = ($i == $current_page) ? 'active' : '';
                echo "<a class='page-button $activeClass' href='?page=$i&search=$search'>$i</a>";
            }
            ?>
        </div>

        <script>
            function confirmDelete(productId) {
                if (confirm("Вы уверены, что хотите удалить этот товар?")) {
                    // Если пользователь подтвердил удаление, отправляем запрос на удаление через AJAX
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Обработка успешного удаления
                            alert("Товар успешно удален.");
                            // Перезагрузите страницу или выполните другие действия, если необходимо
                            window.location.reload();
                        }
                    };
                    xhr.open("GET", "./product/delete_product.php?id=" + productId, true);
                    xhr.send();
                }
            }
        </script>
    </div>
</body>
</html>

