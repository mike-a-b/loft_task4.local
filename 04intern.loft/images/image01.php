<?php

    // http://php.net/manual/ru/ref.image.php

    $img = 'akula.jpg';

    $size = getimagesize($img);
    echo '<pre>'.print_r($size,true).'</pre>';