<?php

session_start();
if (!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
}

echo "Вы обновили эту страницу " . $_SESSION['counter']++ . " раз. ";
echo "<br><a href=" . $_SERVER['PHP_SELF'] . ">обновить</a><br />";

$user = [
    'name' => "Антон Забелин",
    'age' => 36,
    'work' => "web-developer",
    'city' => "Москва"
];

$_SESSION['user'] = $user;

echo "<br><a href='advance.php'>Дополнительная информация</a>";

