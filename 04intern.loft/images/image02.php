<?php 

    // http://php.net/manual/ru/ref.image.php
    
    header('Content-Type: image/jpeg');

    $img = 'akula.jpg';

    $im = imagecreatefromjpeg($img);
    imagejpeg($im);