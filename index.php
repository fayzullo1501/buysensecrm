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

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;    
    }
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    include('login.html');
    exit();
}

include('header.html');

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'add_product':
        include('add_product.php');
        break;
    case 'edit_product':
        include('edit_product.php');
        break;
    case 'delete_product':
        include('delete_product.php');
        break;
    default:
        include('dashboard.php');
        break;
}

$conn->close();
?>
