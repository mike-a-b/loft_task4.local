<?php

$handler = fopen('../test-file', 'r');
while (!feof($handler)) {
    $line = fgets($handler);
    echo $line . '<br />';
}

fclose($handler);