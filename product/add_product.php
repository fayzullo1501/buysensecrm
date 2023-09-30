<!DOCTYPE html>
<html>
<head>
    <title>Добавить товар</title>
    <link rel="stylesheet" href="add_product.css">
</head>
<body>
    <div class="container">
        <h2>Добавить товар</h2>
        <form method="post" action="process_product.php?action=add">
            <label for="name">Название:</label>
            <input type="text" name="name" id="name" required>
            <label for="description">Описание:</label>
            <input type="text" name="description" id="description" required>
            <label for="costprice">Себестоимость:</label> <!-- Добавлено поле "Себестоимость" -->
            <input type="text" name="costprice" id="costprice" required> <!-- Добавлено поле "Себестоимость" -->
            <label for="price">Цена:</label>
            <input type="text" name="price" id="price" required>
            <label for="quantity">Количество:</label>
            <input type="text" name="quantity" id="quantity" required>
            <label for="seller">Диллер:</label>
            <input type="text" name="seller" id="seller" required>
            <label for="phone">Телефон:</label>
            <input type="text" name="phone" id="phone" required>
            <input type="submit" value="Добавить">
        </form>
    </div>
</body>
</html>
