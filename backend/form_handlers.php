<?php
session_start();
$data = [];
$data['error'] = false;
if (isset($_SESSION['id'])) {
    $data['id'] = $_SESSION['id'];
} else {
    $_SESSION['id'] = null;
}

$params = require(__DIR__. '/config.php');
require_once(__DIR__. '/db_functions.php');
require_once __DIR__. '/sec_functions.php';

/*
 * registration form handler
 */
if (isset($_POST['registration'])) {
    $dbh = getConnection($params);

    //валидация данных и запись в базу нового пользователя
    //login (email)
    $data['login'] = isset($_POST['login']) ? $_POST['login'] : '';
    if ($data['login'] = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_EMAIL)) {
        $data['login'] = filter_var($data['login'], FILTER_VALIDATE_EMAIL);
        if (!$data['login']) {
            incorrect_value($data, "Логин содержит недопустимые символы", 422);
        }
        $data['id'] = checkUserExist($dbh, $data['login']);
        if ($data['id'] === false) {
            $_SESSION = null;
        }
        if (($data['id'])) {
            incorrect_value($data, "Пользователь существует, выберите другой логин", 422);
        } // можно регистрировать
    } else {
        $_SESSION['id'] = null;
        incorrect_value($dbh, "Неизвестная ошибка c доступом", 401);
    }

    //password get and check
    $data['password'] = isset($_POST['password']) ? ($_POST['password']) : '';
    $data['password2'] = isset($_POST['password2']) ? ($_POST['password2']) : '';
    if (strcmp($data['password'], $data['password2']) !== 0) {
        incorrect_value($data, "Не совпадают введенные пароли, попробуйте еще раз", 422);
    }
    $data['password'] = hashPassword($data);

    //регистрация
    $data['id'] = $_SESSION['id'] = registerUser($dbh, [$data['login'], $data['password']]);
    closeConnection($dbh);
    //возврат и парсинг значений json
    if (!$data['id']) {
        $data['error'] = "Ошибка попробуйте снова или авторизуйтесь, если вы уже зарегистрированы.";
        $data['password'] = null;
        $data['password2'] = null;
        $data['login'] = null;
    } else {
        $data['error'] = "Вы успешно зарегистрированы";
        $_SESSION['id'] = $data['id'];
        $_SESSION['password'] = $data['password'];
        $_SESSION['login'] = $data['login'];
        $data['password'] = null;
        $data['password2'] = null;
    }
    $data = json_encode($data, JSON_UNESCAPED_UNICODE);
    echo $data;
}
//обработка авторизации
if (isset($_POST['auth'])) {
    $dbh = getConnection($params);
    //логин
    $data['login'] = isset($_POST['login']) ? $_POST['login'] : "";
    if ($data['login'] = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_EMAIL)) {
        $data['login'] = filter_var($data['login'], FILTER_VALIDATE_EMAIL);

        if (!$data['login']) {
            incorrect_value($data, "Логин не существует или содержит недопустимые символы", 422);
        }

        $data['id'] = checkUserExist($dbh, $data['login']);

        if (!$data['id']) {
//            $_SESSION['id'] = null;
            incorrect_value($data, "Неверный логин");
        }
        //пароль
        $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';
        $data['password'] ? hashPassword($data) : null;
        if ($data['password']) {
            //сравнение хеша со значением в БД

            $result = getUserPassword($dbh, $data['login']);
            if (!$result) {
                incorrect_value($data, "Неверный пароль");
            }
            
            if (hash_equals($data['password'], $result)) {
                //успешная авторизация запоминаем сессию
                $_SESSION['id'] = $data['id'];
                $_SESSION['password'] = $data['password'];
                $_SESSION['login'] = $data['login'];

                $data['id'] = null;
                $data['password'] = null;
            } else {
                unset($data);
                $data['error'] = "Неверный пароль";
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
                die();
            }
        }
    }
    $data['error'] = "Вы успешно авторизированы";
    closeConnection($dbh);
    //возврат и парсинг значений json
    $data = json_encode($data, JSON_UNESCAPED_UNICODE);
    echo $data;
}
