<?php

/* Ex.1 */
// // Символ "i" после закрывающего ограничителя шаблона означает регистронезависимый поиск.
// $string = "PHP is the web scripting language of choice.";
// $pattern = "/php/i";
// echo 'Исходная строка: '.$string.'<br>';
// echo 'Шаблон проверки: '.$pattern.'<br>';
// if (preg_match($pattern, $string)) {
//     echo "Вхождение найдено.";
// } else {
//     echo "Вхождение не найдено.";
// }

/* Ex.2 */
// $string = "<b>пример: </b><div align=left>это тест</div>"; 
// $pattern = "|<[^>]+>(.*)</[^>]+>|U";
// preg_match_all($pattern,
//     $string,
//     $out, PREG_PATTERN_ORDER);
// echo '<textarea rows="30" cols="80">';
// echo 'Исходная строка: '.$string."\n";
// echo 'Шаблон: '.$pattern."\n";
// print_r($out);
// echo '</textarea>';


/* Ex.3 */
// $string = 'We will replace the word foo';
// $pattern = "/foo/";
// $replace = "bar";
// echo 'Исходная строка: '.$string.'<br>';
// echo 'Шаблон: '.$pattern.'<br>';
// echo 'Замена: '.$replace.'<br>';
// $string = preg_replace($pattern, $replace, $string);
// echo $string;