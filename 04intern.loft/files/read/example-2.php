<?php

$handler = fopen('../test-file', 'r');

echo nl2br(fread($handler, 500));

fclose($handler);