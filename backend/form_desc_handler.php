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
$file = $_FILES['upload'];
    //валидация
if (preg_match('/jpg/', $file['name']) or preg_match('/png/', $file['name'])
    or preg_match('/gif/', $file['name'])) {
    if (preg_match('/jpeg/', $file['type']) or preg_match('/jpg/', $file['type']) or preg_match('/png/', $file['type'])
        or preg_match('/gif/', $file['type'])) {
        $data['name'] = isset($_POST['name']) ? $_POST['name'] : '';
        $data['age'] = intval(isset($_POST['age'])) ? $_POST['age'] : '';
        $data['description'] = isset($_POST['description']) ? $_POST['description'] : '';
        //validation
        $data['name'] = strip_tags($data['name']);
        $data['name'] = htmlspecialchars($data['name'], ENT_QUOTES);
        $data['age'] = filter_var($data['age'], FILTER_SANITIZE_NUMBER_INT);
        $data['description'] = strip_tags($data['description']);
        $data['description'] = htmlspecialchars($data['description'], ENT_QUOTES);
        
        //сохраняем описание в базу и сохраняем photo
        $dir = $_SERVER['DOCUMENT_ROOT'].'/';
        $data['file_type'] = explode('/', $file['type']);
        $filename = 'photos/' . $data['id'].'.'.$data['file_type'][1];
        $path = $dir.$filename;
        $dbh = getConnection($params);

        if (($file_old = getImage($dbh, $data['id']))) {
            $file_old = $dir.$file_old;
            if (file_exists($file_old)) {
                if (!unlink($file_old)) {
                    incorrect_value($data, "Ошибка удаления старого фото", 503);
                }
            } else {
                $data['error'] = "Файл не существует";
            }
        }

        $id_img = saveDescriptionData($dbh, $data);
        $id_img = explode(':', $id_img);
        $id_img = implode("", $id_img);
        //сохраняем хвост новой, добавлять к фото для тех у кого это происходил
        //уменя нет
        $_SESSION['id_img'] = $id_img;
    
        if (isset($id_img)) {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/photos/')) {
                mkdir($_SERVER['DOCUMENT_ROOT'].'/photos/', 0775);
            }
            if (move_uploaded_file($file['tmp_name'], $path)) {
                $data['error']  = "Файл успешно записан";
            } else {
                incorrect_value($data, "Ошибка записи файла", 400);
            }
            //          путь до файла
            $data['upload'] = $filename;
            saveImageToDB($dbh, $data);
        }
        closeConnection($dbh);
    }
} else {
    $data['error'] = "Данные не записаные попробуйте еще раз";
}
$data['error'] = "Данные успешно записаны";
$data = json_encode($data, JSON_UNESCAPED_UNICODE);
echo $data;
