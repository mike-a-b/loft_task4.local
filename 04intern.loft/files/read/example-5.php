<?php

$handler = fopen('../test-file', 'r');

// Сдвинуть указатель
fseek($handler, 2000);

while(!feof($handler)){
    $line = fgets($handler);
    echo $line.'<br />';
}

fclose($handler);