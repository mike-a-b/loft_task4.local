<?php
session_start();
$data = [];
$data['error'] = false;
if (isset($_SESSION['id'])) {
    $data['id'] = $_SESSION['id'];
} else {
    $_SESSION['id'] = null;
}
//error_reporting(E_ALL | E_STRICT);
//подключаю функционал и модуль laravel/symphony по работе с изображениями
$params = require(__DIR__. '/config.php');
require_once(__DIR__. '/db_functions.php');
require_once __DIR__. '/sec_functions.php';

$file = $_FILES['upload'];
require(__DIR__."/../vendor/autoload.php");
//use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic as Image;

Image::configure(/*array('driver' => 'imagick')*/);

if (preg_match('/jpg/', $file['name']) or preg_match('/png/', $file['name'])
    or preg_match('/gif/', $file['name'])) {
    if (preg_match('/jpeg/', $file['type']) or preg_match('/jpg/', $file['type']) or preg_match('/png/', $file['type'])
        or preg_match('/gif/', $file['type'])) {
        //удаляем предыдущий файл


        //Проверяем mime type
        $img = Image::make($file['tmp_name']); //Открываем
        $img->resize(100, 100); //Изменяем размер
        //валидация
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
        //перед этим удаляем предыдущую
        $dbh = getConnection($params);

        if (($file_old = getImage($dbh, $data['id']))) {
            if (file_exists($file_old)) {
                if (!unlink($file_old)) {
                    die("Error delete old photo");
                }
            }
        }

        $id_img = saveDescriptionData($dbh, $data);

        if (isset($id_img)) {
            $data['file_type'] = explode('/', $file['type']);
            $path = 'photos/' . $data['id'].'.'.$data['file_type'][1];
            $path2 = $path . '?'.$id_img;

            if (!$img->mime()) {
                incorrect_value($data, "неверный mime type");
            } else {
                $jpg = (string)$img->encode('jpg', 90);
                //save не смогу заставить заработать стандартно через GD драйвер получаю строку JPG из любого файла
            }
//            $img->save($path, 100); //не работает c хвостом path2  пробовал
            // с ларавел и т д Imagick GD в конфиге ругается на путь и с path просто для избежания кеширования изображения
            // поэтому записываю $img->encode
//            $path2 = 'photos/' . $data['id'] . '.' . $data['file_type'][1] . '?'.$id_img;
            $handle = fopen($path2, 'w');

            fwrite($handle, $jpg.PHP_EOL);
            fclose($handle);
            $data['upload'] = $path2;
            saveImageToDB($dbh, $data);
            $img->destroy();
            unlink($file['tmp_name']);
        }

        //сохраняем хвост новой
        $_SESSION['id_img'] = $id_img;
        closeConnection($dbh);
    }
}
$data['error'] = "Данные успешно записаны";
$data = json_encode($data, JSON_UNESCAPED_UNICODE);
echo $data;