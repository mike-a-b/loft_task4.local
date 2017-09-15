<?php

function getConnection(array $params)
{
    try {
        $dsn = "mysql:host=" . $params['host'] . ";dbname=" . $params['dbname'];
        $dbh = new PDO($dsn, $params['user'], $params['password']);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        print "Ошибка!: " . $e->getMessage() . "<br/>";
        $handle = fopen('PDOErrors.txt', 'a+');
        fwrite($handle, $e->getMessage().PHP_EOL);
        fclose($handle);
        die("Ошибка при подключении к БД или SQL синтаксиса");
    }
    $dbh->exec("set names utf8");
    $dbh->exec("use lofttask4");
    return $dbh;
}

function closeConnection(PDO &$dbh)
{
    $dbh = null;
}

function getAllRegisterUsers(PDO &$dbh)
{
    $sth = $dbh->query("select * from users");
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    $data = $sth->fetchAll();
    return $data;
}

function checkUserExist(PDO &$dbh, $email)
{
    $sql = "select id, login from users where login = :email";
    $sth = $dbh->prepare($sql);
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    $sth->execute(array(":email" => $email));
    $data = $sth->fetchAll();
    if (isset($data[0]['login'])) {
        return $data[0]['id'];
    } else {
        return false;
    }
}

function registerUser(PDO &$dbh, array $data)
{
    $ar_data = [$data[0], $data[1]];
    $sql = "insert into users (login, password) values (? , ?)";
    $sth = $dbh->prepare($sql);
    $sth->execute($ar_data);
    $uid = checkUserExist($dbh, $data[0]);//поиск id по логину
    return $uid;
}

//function checkRegisterUser(PDO &$dbh, &$data)
//{
//    $sql = 'select * from users where login = ? and password = ?';
//    $sth = $dbh->prepare($sql);
//    $sth->setFetchMode(PDO::FETCH_ASSOC);
//    $sth->bindValue(1, $data['login']);
//    $sth->bindValue(2, $data['password']);
//    try {
//        $sth->execute();
//        $res = $sth->fetchAll();
//    } catch (PDOException $e) {
//        die("error request". $e->getMessage());
//    }
//    if (isset($res[0]['login']) && isset($res[0]['password'])) {
//        //сравниваем пассворд
//        if (hash_equals($res[0]['password'], $data['password'])) {
//            return $res[0]['id'];
//        } else {
//            incorrect_value($data, "Неверный пароль или логин", 422);
//        }
//    }
//    return false;
//}

function getUserPassword(PDO &$dbh, $email)
{
    $sql = "select id, login, password from users where login = :email";
    $sth = $dbh->prepare($sql);
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    $sth->execute(array(":email" => $email));
    $data = $sth->fetchAll();
    if (isset($data[0]['login'])) {
        return $data[0]['password'];
    } else {
        return false;
    }
}

function saveDescriptionData(PDO &$dbh, &$data)
{
//    $ar_data = [$data['name'], $data['age'], $data['description']];
    $sql = "update users set name = ?, age = ?, description = ? where id = ?";
    $sth = $dbh->prepare($sql);
    $sth->bindParam(1, $data['name'], PDO::PARAM_STR);
    $sth->bindParam(2, $data['age'], PDO::PARAM_INT);
    $sth->bindParam(3, $data['description'], PDO::PARAM_STR);
    $sth->bindParam(4, $data['id'], PDO::PARAM_INT);

//    $sth->execute($ar_data);
    if ($sth->execute()) {
//        $img_id = date("H:i:s");
        $img_id = 'v='.((string)date("H:i:s"));
        return $img_id;
    }
    return false;
}

function saveImageToDB(&$dbh, &$data)
{
    $sql = "update users set photo = ? where id = ?";
    $sth = $dbh->prepare($sql);
    $sth->bindParam(1, $data['upload'], PDO::PARAM_STR);
    $sth->bindParam(2, $data['id'], PDO::PARAM_INT);
    if ($sth->execute()) {
        return true;
    }
    return false;
}
function getImage(&$dbh, $id)
{
    $sql = "select photo from users where id = :id";
    $sth = $dbh->prepare($sql);
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    $sth->execute(array(":id" => $id));
    $data = $sth->fetchAll();
    if (isset($data[0]['photo'])) {
        return $data[0]['photo'];
    } else {
        return false;
    }
}
