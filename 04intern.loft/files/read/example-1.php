<?php

$text = file_get_contents('../test-file');
// echo $text;
echo nl2br($text);