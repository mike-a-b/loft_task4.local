<?php

$handle = fopen('write-file', 'a+');
fwrite($handle, 'Тестовая запись в файл'.PHP_EOL);
fclose($handle);

