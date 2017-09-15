<?php

$handle = fopen('write-file-2', 'w');
fwrite($handle, 'Тестовые данные'.PHP_EOL, 10);
fclose($handle);
