<!DOCTYPE html>
<html>
<head>
    <title>Добавить клиента</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            background-color: #07223f;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #051727;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Добавть</h2>
        <form method="post" action="clients_process.php?action=add">
            <label for="fio">ФИО:</label>
            <input type="text" name="fio" id="fio" required>
            <label for="purchase_name">Название покупки:</label>
            <input type="text" name="purchase_name" id="purchase_name" required>
            <label for="purchase_code">Код покупки:</label>
            <input type="text" name="purchase_code" id="purchase_code" required>
            <label for="address">Адрес клиента:</label>
            <input type="text" name="address" id="address" required>
            <label for="phone">Телефон:</label>
            <input type="text" name="phone" id="phone" required>
            <input type="submit" value="Добавить">
        </form>
    </div>
</body>
</html>
