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
// файл все равно перезаписывается если одно название
        if (($file_old = getImage($dbh, $data['id']))) {
            if (file_exists($file_old)) {
                if (!unlink($file_old)) {
                    die("Ошибка удаления старого фото");
                }
            } else {
                $data['error'] = "Файл не существует";
            }
        }

        $id_img = saveDescriptionData($dbh, $data);
        $id_img = explode(':', $id_img);
        $id_img = implode("", $id_img);

        if (isset($id_img)) {
            $data['file_type'] = explode('/', $file['type']);
            $path = 'photos/' . $data['id'].'.'.$data['file_type'][1];
            $path2 = $path .'?'.$id_img;

            if (!$img->mime()) {
                incorrect_value($data, "неверный mime type");
            }
            $jpg = (string)$img->encode('jpg', 90);
            $img->save($path, 100); //не работает c хвостом path2  пробовал
            move_uploaded_file($file['tmp_name'], $path);
  /*              //save не смогу заставить заработать стандартно через GD драйвер получаю строку JPG из любого файла


            // с ларавел и т д Imagick GD в конфиге ругается на путь и с path просто для избежания кеширования изображения
            // поэтому записываю $img->encode [
            // = fopen('anotherrtest.txt', "wt") or die('Ошибка при отрытии
//        todo    $handle = fopen($path2, 'wt') or die('Ошибка при отрытии photo');
//            if (isset($handle)) {
//                fwrite($handle, $jpg . PHP_EOL) or die("Ошибка записи фото");
//                fclose($handle);
//            }
            */
  // todo не работает
//            file_put_contents($path2, $jpg.PHP_EOL);// or die("Ошибка записи фото");
            $file = $_FILES['file'];
            $data['upload'] = $path2;
            saveImageToDB($dbh, $data);
            $img->destroy();
            unlink($file['tmp_name']);
        }

        //сохраняем хвост новой
        $_SESSION['id_img'] = $id_img;
        closeConnection($dbh);
    }
} else {
    $data['error'] = "Данные не записаные попробуйте еще раз";
}
$data['error'] = "Данные успешно записаны";
$data = json_encode($data, JSON_UNESCAPED_UNICODE);
echo $data;
