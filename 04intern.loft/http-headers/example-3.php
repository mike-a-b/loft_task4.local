<?php
header('Content-Disposition: attachment; filename=file.png');
// читаем содержимое файла
readfile('PHP.png');
exit;