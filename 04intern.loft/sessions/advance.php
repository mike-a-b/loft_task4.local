<?php

session_start();

$user = null;

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

if (!is_null($user)) {

    echo <<<HERE222
        Имя: $user[name]<br />
        Возраст: $user[age]<br />
        Род занятий: $user[work]<br />
        Город: $user[city]<br />
HERE222;

} else {

    echo "<br />Нет данных о пользователе<br />";

}

echo "<br /><a href='logout.php'>Закрыть сессию</a> | <a href='/sessions/'>Перейти на главную</a><br />";
