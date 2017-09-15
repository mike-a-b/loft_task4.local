<?php
date_default_timezone_set('Europe/Moscow');
echo 'Текущее дата/время в unix: ' . time() . '<br>';
echo 'Текущее дата/время #1: ' . date('Y/m/d H:i:s', time()) . '<br>';
echo 'Текущее дата/время #2: ' . date('d.m.Y H:i') . '<br>';
echo '=======================================================<br>';

$mt = mktime(0, 0, 0, 1, 1, 1970);
echo $mt . '<br>';
echo 'Преобразовано mktime: ' . $mt . '<br>';
echo 'Дата/время: ' . date('d.m.Y H:i', $mt) . '<br>';
echo '=======================================================<br>';

$mt = mktime(22, 40, 0, 7, 15, 2017);
echo $mt . '<br>';
echo 'Преобразовано mktime: ' . $mt . '<br>';
echo 'Дата/время: ' . date('d.m.Y H:i', $mt) . '<br>';
echo '=======================================================<br>';

$time = time();
$two = $time + 60 * 60 * 2;
echo date('d.m.Y H:i', $two);
echo "==========";
$a = 3;
$b = 5;
$a = $a - $b * $a / $b;
$c = 55 % 2;
var_dump($c);

