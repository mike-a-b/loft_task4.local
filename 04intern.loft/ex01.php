<?php

$garr = [
    'GLOBALS' => 'cсылки на все переменные глобальной области видимости',
    '_ENV' => 'переменные окружения',
    '_SERVER' => 'информация о сервере и среде исполнения',
    '_COOKIE' => 'HTTP Куки',
    '_SESSION' => 'переменные сессии',
    '_FILES' => 'переменные файлов, загруженных по HTTP',
    '_GET' => 'HTTP GET переменные',
    '_POST' => 'HTTP POST переменные',
    '_REQUEST' => 'ассоциативный массив (array), который по умолчанию содержит данные',
];

//echo "<pre>";
//require "server.php";
foreach ($garr as $key => $value) {
    echo '<p><b>$'.$key.'</b> - '.$value.'</p>';
    echo '<pre>'.print_r($$key,true).'</pre><hr>';
}
