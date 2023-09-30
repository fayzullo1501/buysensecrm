<!DOCTYPE html>
<html>
<head>
    <title>Изменить данные клиента</title>
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
    <h2>Изменить клиента</h2>
    <form method="post" action="client_process.php?action=edit">
        ID клиента: <input type="text" name="id"><br>
        ФИО: <input type="text" name="fio"><br>
        Название покупки: <input type="text" name="purchase_name"><br>
        Код покупки: <input type="text" name="purchase_code"><br>
        Адрес: <input type="text" name="address"><br>
        Телефон: <input type="text" name="phone"><br>
        <input type="submit" value="Изменить">
    </form>
    </div>
</body>
</html>
