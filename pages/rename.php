<?php

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная заказов</title>
</head>
<body>

<header style="display: flex; background-color: rgba(27, 27, 27, 0.82);color: white; align-items: center; flex-wrap: row; gap: 25px; padding: 20px; max-height: 30px; ">

     <h1>TechStore</h1>

    <a href="./maine.php" style="color: white; margin-left: 30%; font-size: 1.5em">Главная</a>
    <a href="./acc.php" style="color: white; font-size: 1.5em">Корзина</a>

    <?php

 if (isset($_SESSION['shooterki']) && $_SESSION['shooterki'] === '7') {
     echo '<a href="./admin.php" style="color: white; font-size: 1.5em">Админ панель</a>';
 }

 if (isset($_SESSION['shooterki']) && $_SESSION['shooterki'] != '7') {
    echo '<a href="./acc.php" style="color: white; font-size: 1.5em">Мой аккаунт</a>';
}
 ?>
   <a href="./logout.php" style="color: white; font-size: 1.5em">Выйти</a>
</header>

     <h1 style=" text-align: center; font-size: 3.1em;">Каталог товаров</h1>
    <?php
// Подключение к базе данных
$conn = new mysqli("localhost", "root", "root", "shooterki");

if ($conn->connect_error) {
    die("Ошибка: " . $conn->connect_error);
}


// Запрос к базе данных
$query = "SELECT id, name, described, price, image, rate FROM tovar WHERE id > 0";
$result = $conn->query($query);

// Проверка, есть ли записи
if ($result->num_rows > 0) {
    // Вывод записей в ряд по 4
    echo '<div style="display: flex; flex-wrap: wrap; gap: 20px; padding: 20px;">';
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        echo '<div style="flex: 1 1 50px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.47); padding: 15px; border-radius: 8px; text-align: center; width: 40px; flex-direction: row;">';
        
        echo '<img src="data:image/png;base64,' . base64_encode($row['image']) . '" width="200px" height="200px" style="border-radius: 8px;"/>';
        echo '<h2 style="font-size: 1.5em; margin: 10px 0;">' . htmlspecialchars($row['name']) . '</h2>';
        echo '<p style="font-size: 1em; color: #555; margin: 10px 0;">' . htmlspecialchars($row['described']) . '</p>';
        echo '<p style="font-size: 1em; color: #333; margin: 10px 0;">Рейтинг: ' . htmlspecialchars($row['rate']) . '</p>';
        echo '</div>';
        
        $count++;
        if ($count % 4 == 0) {
            echo '</div><div style="display: flex; flex-wrap: wrap; gap: 20px; padding: 20px;">';
        }
    }
    echo '</div>';
} else {
    // Если записей нет
    echo '<p style="text-align: center; font-size: 1.2em; color: #555; margin: 20px;">Товаров временно нет в наличии</p>';
}

// Закрытие соединения
$conn->close();
?> 
</body>
</html>
