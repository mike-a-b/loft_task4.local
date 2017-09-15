<?php

// echo '<pre>'; print_r($_FILES); exit;

$file = $_FILES['file'];

$dir = 'uploads';

if (!file_exists($dir)) {
    mkdir($dir, 0777);
}

$file_name = $dir . '/' . $file['name'];

if (move_uploaded_file($file['tmp_name'], $file_name)) {
    echo "<p>Файл успешно загружен</p>";
    echo '<p>Путь до файла: ' . $file_name . '</p>';
    echo '<p><a href="' . $file_name . '" target="_blank">открыть файл</a></p>';
} else {
    echo "Возникла ошибка при загрузке файла";
}