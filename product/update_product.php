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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $seller = $_POST['seller'];
    $phone = $_POST['phone'];
    $costprice = $_POST['costprice'];

    $query = "UPDATE products SET name='$name', description='$description', price='$price', quantity='$quantity', seller='$seller', phone='$phone', costprice='$costprice' WHERE id='$id'";

    if ($conn->query($query) === TRUE) {
        header("Location: ../uchet.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
