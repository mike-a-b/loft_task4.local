<?php

$data_file = file('../test-file');

echo '<pre>';
print_r($data_file);

foreach($data_file as $line){
    //echo $line.'<br />';
}