<?php

// пример чтения директории

$dir = opendir('.');

while ($fl = readdir($dir)) {
    echo $fl . ' - ' . (is_dir($fl) ? '[DIR]' : 'file') . '<br>';
}
