<?php

$handler = fopen('../test-file', 'r');

ob_start(); // включает буферизацию

// Читает указанный файловый указатель с текущей позиции до EOF (конца файла)
// Выводит всё на экран
$symbols = fpassthru($handler);

echo "<br /><br />Это вебинар по PHP от Loftschool<br />";

// отключаем буферизацию, заносим в переменную, очищаем буфер
$file_content = ob_get_clean();
fclose($handler);

echo nl2br($file_content);
echo "<br />Было считано {$symbols} символов";