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
        $id = $_POST['id'];
        $fio = $_POST['fio'];
        $purchase_name = $_POST['purchase_name'];
        $purchase_code = $_POST['purchase_code'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        $query = "INSERT INTO clients (fio, purchase_name, purchase_code, address, phone) VALUES ('$fio', '$purchase_name', '$purchase_code', '$address', '$phone')";
        $conn->query($query);
        break;
    case 'edit':
        $id = $_POST['id'];
        $fio = $_POST['fio'];
        $purchase_name = $_POST['purchase_name'];
        $purchase_code = $_POST['purchase_code'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        $query = "UPDATE clients SET fio='$fio', purchase_name='$purchase_name', purchase_code='$purchase_code', address='$address', phone='$phone' WHERE id=$id";
        $conn->query($query);
        break;
    case 'delete':
        $id = $_POST['id'];

        $query = "DELETE FROM clients WHERE id=$id";
        $conn->query($query);
        break;
}

$conn->close();

header("Location: clients.php");
exit();
?>
