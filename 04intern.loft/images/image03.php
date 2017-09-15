<?php 

    // http://php.net/manual/ru/ref.image.php
    
    header('Content-Type: image/jpeg');

    $img = 'akula.jpg';

    $size = getimagesize($img);

    $widthEllips = 70; // ширина эллипса
    $heightEllips = 40; // высота эллипса

    $minx = $widthEllips/2;
    $maxx = $size[0] - $minx;
    $miny = $heightEllips/2;
    $maxy = $size[1] - $miny;

    $x = rand($minx, $maxx);
    $y = rand($miny, $maxy);

    // создаём изображение
    $im = imagecreatefromjpeg($img);
    
    // формируем цвет
    $col = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));

    // выводим эллипс
    imagefilledellipse($im, $x, $y, $widthEllips, $heightEllips, $col);

    // выводим картинку
    imagejpeg($im);