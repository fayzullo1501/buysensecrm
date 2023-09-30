<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "buysensecrm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'add':
        $description = $_POST['description']; 
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $seller = $_POST['seller'];
        $phone = $_POST['phone'];
        $name = $_POST['name']; // Добавленное поле "name"
        $costprice = $_POST['costprice']; // Добавленное поле "costprice"

        $query = "INSERT INTO products (description, price, quantity, seller, phone, name, costprice) VALUES ('$description', $price, $quantity, '$seller', '$phone', '$name', $costprice)";
        $conn->query($query);
        break;
    case 'edit':
        $id = $_POST['id'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $seller = $_POST['seller'];
        $phone = $_POST['phone'];
        $name = $_POST['name']; // Добавленное поле "name"
        $costprice = $_POST['costprice']; // Добавленное поле "costprice"

        $query = "UPDATE products SET description='$description', price=$price, quantity=$quantity, seller='$seller', phone='$phone', name='$name', costprice=$costprice WHERE id=$id";
        $conn->query($query);
        break;
    case 'delete':
        $id = $_POST['id'];

        $query = "DELETE FROM products WHERE id=$id";
        $conn->query($query);
        break;
}

$conn->close();

header("Location: ../uchet.php");
exit();
?>
