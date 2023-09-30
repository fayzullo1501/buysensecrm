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

$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($id)) {
    // Запрос на выборку данных о товаре с указанным ID
    $query = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
        $quantity = $row['quantity'];
        $seller = $row['seller'];
        $phone = $row['phone'];
        $costprice = $row['costprice'];
    } else {
        echo "Товар не найден!";
    }
} else {
    echo "Не указан ID товара!";
}

// Закрываем соединение с базой данных
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Изменить</title>
    <link rel="stylesheet" href="edit_product.css">
</head>
<body>
    <div class="container">
    <h2>Изменить товар</h2>
    <form method="post" action="update_product.php">
        <!-- Поле для передачи ID товара (скрытое) -->
        <input type="text" name="id" value="<?php echo $id; ?>" style="display: none;">
        <label for="name">Название товара:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
        <label for="description">Описание товара:</label>
        <input type="text" id="description" name="description" value="<?php echo $description; ?>" required>
        <label for="price">Цена товара:</label>
        <input type="text" id="price" name="price" value="<?php echo $price; ?>" required>
        <label for="quantity">Количество товара:</label>
        <input type="text" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required>
        <label for="seller">№ магазина:</label>
        <input type="text" id="seller" name="seller" value="<?php echo $seller; ?>" required>
        <label for="phone">Номер телефона продавца:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required>
        <label for="costprice">Себестоимость товара:</label>
        <input type="text" id="costprice" name="costprice" value="<?php echo $costprice; ?>" required>
        <input type="submit" value="Сохранить изменения">
    </form>
    </div>
</body>
</html>
