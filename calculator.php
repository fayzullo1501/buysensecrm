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
    <title>Калькулятор</title>
    <link rel="stylesheet" href="calculator.css">
</head>
<body>
    <!-- Navigation -->
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h1>Калькулятор</h1>

        <!-- Форма для калькулятора -->
        <form id="calculatorForm">
            <label for="amount">Сумма:</label>
            <input type="number" id="amount" step="0.01" required>
            
            <label for="months">Срок:</label>
            <select id="months" required>
                <option value="6">6 месяцев</option>
                <option value="12">12 месяцев</option>
            </select>
            
            <button type="submit">Рассчитать</button>
        </form>

        <!-- Результаты расчета будут отображены здесь -->
        <div id="result"></div>

        <script>
            const form = document.getElementById('calculatorForm');
            const resultDiv = document.getElementById('result');
          
            form.addEventListener('submit', function(event) {
              event.preventDefault();
              
              const amountInput = document.getElementById('amount');
              const monthsSelect = document.getElementById('months');
          
              const amount = parseFloat(amountInput.value);
              const months = parseInt(monthsSelect.value);
          
              if (months === 6) {
                const amountWithInterest = amount * 1.20 * 1.26 / 6;
                const installment = (amountWithInterest / 1).toFixed(2);
                resultDiv.innerText = `6 месяцев: ${installment} сум.`;
              } else if (months === 12) {
                const amountWithInterest = amount * 1.20 * 1.44 / 12;
                const installment = (amountWithInterest / 1).toFixed(2);
                resultDiv.innerText = `12 месяцев: ${installment} сум.`;
              }
            });
        </script>
    </div>
</body>
</html>
