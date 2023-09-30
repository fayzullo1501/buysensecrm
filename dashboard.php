<!-- <?php
$query = "SELECT * FROM products";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>
    <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Description</th>
    <th>Price</th>
    <th>Quantity</th>
    </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>" . $row['id'] . "</td>
        <td>" . $row['name'] . "</td>
        <td>" . $row['description'] . "</td>
        <td>" . $row['price'] . "</td>
        <td>" . $row['quantity'] . "</td>
        </tr>";
    }

    echo "</table>";
} else {
    echo "No products found.";
}
?> -->

<!DOCTYPE html>
<html>
<head>
    <title>Главная - Панель управления</title>
    <style>
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
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
    <div class="content">
        <h1>Добро пожаловать!</h1>
        <img src="./images/uz.svg" alt="Uzbekistan Map" class="country-map">
    </div>
</body>
</html>

