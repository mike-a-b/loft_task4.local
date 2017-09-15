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
//require(__DIR__."/../vendor/

//use Intervention\Image\Image;

//use Intervention\Image\ImageManagerStatic as Image;

//Image::configure(array('driver' => 'imagick'));

if (preg_match('/jpg/', $file['name']) or preg_match('/png/', $file['name'])
    or preg_match('/gif/', $file['name'])) {
    if (preg_match('/jpeg/', $file['type']) or preg_match('/jpg/', $file['type']) or preg_match('/png/', $file['type'])
        or preg_match('/gif/', $file['type'])) {
        //
//        $img = Image::make($file['tmp_name']); //Открываем
//        $img->resize(100, 100); //Изменяем размер
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
            $filename = 'photos/' . $data['id'].'.'.$data['file_type'][1];
            $filename2 = $filename .'?'.$id_img;
            if (!file_exists('/../photos')) {
                mkdir('/../photos', 0775);
            }
//            if (!$img->mime()) {
//                incorrect_value($data, "неверный mime type");
//            }
//            $jpg = (string)$img->encode('jpg', 90);
//            $img->save('photos/', 100); //не  работает
            if (move_uploaded_file($file['tmp_name'], $filename)) {
                $data['error']  = "Файл успешно записан";
            } else {
                incorrect_value($data, "Ошибка записи файла", 400);
            }
//            file_put_contents($filename, $jpg.PHP_EOL) or die("Ошибка записи файла");
            //save не смогу заставить заработать стандартно через GD драйвер получаю строку JPG из любого файла


            // с ларавел и т д Imagick GD в конфиге ругается на путь и с path просто для избежания кеширования изображения
//            // поэтому записываю $img->encode [
//            $handle = fopen($filename, 'wt') or die('Ошибка при отрытии photo');
//            if (isset($handle)) {
//                fwrite($handle, $jpg . PHP_EOL) or die("Ошибка записи фото");
//                fclose($handle);
//            }

  // todo не работает
//            file_put_contents($filename2, $jpg.PHP_EOL);// or die("Ошибка записи фото");
            //путь до файла
//            $file = $_FILES['upload'];
            $data['upload'] = $filename;
            saveImageToDB($dbh, $data);
//            $img->destroy();
            unlink($file['tmp_name']);
            //сохраняем хвост новой
            $_SESSION['id_img'] = $id_img;
            $_SESSION['photo'] = $filename;
        }


        closeConnection($dbh);
    }
} else {
    $data['error'] = "Данные не записаные попробуйте еще раз";
}
$data['error'] = "Данные успешно записаны";
$data = json_encode($data, JSON_UNESCAPED_UNICODE);
echo $data;
