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
    <title>Клиенты</title>
    <style>
        /* Стилизация таблицы */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        /* Стилизация кнопок и формы */
        .action-buttons {
            margin-bottom: 20px;
        }
        
        .search-form {
            margin-bottom: 20px;
        }
        
        .search-form input[type="text"] {
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .search-form input[type="submit"] {
            background-color: #07223f;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 15%;
            background-color: #07223f;
            color: white;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .content {
            width: 85%;
            background-color: #f0f0f0;
            padding: 20px;
            box-sizing: border-box;
        }

        .menu-item {
            margin-bottom: 35px;
            display: flex;
            align-items: center;
        }

        .menu-item a {
            text-decoration: none;
            color: white;
            margin-left: 30px;
        }

        .menu-item img {
            width: 20px;
            height: auto;
        }

        .spacer {
        }

        .bottom-menu {
            margin-top: auto;
        }

        .country-map {
            width: 70%;
            height: auto;
            align-items: center 
        }

        a {
        text-decoration: none;
        color: #000;
        }

        .edit-button, .delete-button {
        background-color: #07223f;
        color: white;
        border: none;
        padding: 6px 10px;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 5px;
        }

        .edit-button:hover, .delete-button:hover {
            background-color: #04396c;
        }

        /* Стили для кнопок переключения страниц */
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        
        .page-button {
            display: inline-block;
            padding: 6px 12px;
            margin-right: 5px;
            border: 1px solid #ddd;
            background-color: #f2f2f2;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .page-button.active {
            background-color: #07223f;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="user-avatar">
            <img src="../images/logo.png" alt="Logo" style="width: 70%; height: auto; margin-bottom: 50px; margin-top: 10px">
        </div>
        <div class="menu-item">
            <img src="../images/home-icon.png" alt="Home">
            <a href="../index.php">Главная</a>
        </div>
        <div class="menu-item">
            <img src="../images/product-icon.png" alt="Products">
            <a href="../uchet.php">Склад</a>
        </div>
        <div class="menu-item">
            <img src="../images/user-icon.png" alt="Users">
            <a href="./clients.php">Клиенты</a>
        </div>
        <div class="menu-item">
            <img src="../images/user-icon.png" alt="Users">
            <a href="../calculator.php">Калькулятор</a>
        </div>
        <div class="spacer"></div>
        <div class="menu-item">
            <img src="../images/settings-icon.png" alt="Settings">
            <a href="#">Настройки</a>
        </div>
        <div class="menu-item bottom-menu">
            <img src="../images/logout-icon.png" alt="Logout">
            <a href="../logout.php">Выход</a>
        </div>
    </div>
    </div>
    <div class="content">
        <h1>Клиенты</h1>
        
        <!-- Кнопка для перехода на страницу добавления клиента -->
        <div class="action-buttons">
            <a href="client_add.php"><button>Добавить клиента</button></a>
        </div>
        
        <!-- Форма для поиска клиентов -->
        <div class="search-form">
            <form method="get" action="">
                <input type="text" name="search" placeholder="Поиск клиентов">
                <input type="submit" value="Искать">
            </form>
        </div>
        
        <!-- Таблица для вывода клиентов -->
        <table>
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Название покупки</th>
                <th>Код покупки</th>
                <th>Адрес</th>
                <th>Телефон</th>
                <th>Действия</th>
            </tr>
            <!-- PHP-код для вывода данных из базы с учетом поискового запроса и пагинации -->
            <?php
            // Определение количества клиентов на одной странице
            $itemsPerPage = 7;

            // Получите значение параметра search из GET-запроса
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Запрос на выборку клиентов с учетом поискового запроса
            $query = "SELECT COUNT(*) as total FROM clients WHERE fio LIKE '%$search%'";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            $totalItems = $row['total'];

            // Определение текущей страницы
            $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

            // Рассчитайте общее количество страниц
            $totalPages = ceil($totalItems / $itemsPerPage);

            // Вычисление смещения для запроса
            $offset = ($currentPage - 1) * $itemsPerPage;

            // Запрос на выборку клиентов с учетом поискового запроса и пагинации
            $query = "SELECT * FROM clients WHERE fio LIKE '%$search%' LIMIT $itemsPerPage OFFSET $offset";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['fio'] . "</td>
                    <td>" . $row['purchase_name'] . "</td>
                    <td>" . $row['purchase_code'] . "</td>
                    <td>" . $row['address'] . "</td>
                    <td>" . $row['phone'] . "</td>
                    <td>
                        <a href='edit_client.php?id=" . $row['id'] . "'><button class='edit-button'>Изменить</button></a>
                        <button class='delete-button' onclick='confirmDelete(" . $row['id'] . ")'>Удалить</button>
                    </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Клиенты не найдены!</td></tr>";
            }
            ?>
        </table>

        <!-- Кнопки для переключения между страницами -->
        <div class="pagination">
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                $activeClass = ($i == $currentPage) ? 'active' : '';
                echo "<a class='page-button $activeClass' href='?page=$i&search=$search'>$i</a>";
            }
            ?>
        </div>
        <script>
    function confirmDelete(clientId) {
        if (confirm("Вы уверены, что хотите удалить этого клиента?")) {
            // Если пользователь подтвердил удаление, отправляем запрос на удаление через AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Обработка успешного удаления
                    alert("Клиент успешно удален.");
                    // Перезагрузите страницу или выполните другие действия, если необходимо
                    window.location.reload();
                }
            };
            xhr.open("GET", "./delete_client.php?id=" + clientId, true);
            xhr.send();
        }
    }
</script>

    </div>
</body>
</html>
