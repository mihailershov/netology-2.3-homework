<?php

// Декодируем json файл, достаем нужные данные
$array = json_decode(file_get_contents('userinfo.json'));
$username = $array[0];
$testname = $array[1];
$correct = $array[2];
$date = $array[3];
unlink('userinfo.json');

// Создаем картинку и цвет шрифта
$img = imagecreatefromjpeg('img/picture.jpg');
$white = imagecolorallocate($img,255,255,255);

// Определяем положение имени пользователя (по центру)
$imageWidth = getimagesize('img/picture.jpg');
$imageWidth = $imageWidth[0];
$textPoints = imagettfbbox(300, 0, 'fonts/OpenSans.ttf', $username);
$textWidth = $textPoints[2] - $textPoints[0];
$x = ($imageWidth - $textWidth) / 2;

// Распологаем все данные на картинке
imagettftext($img, 300, 0, $x, 600, $white, 'fonts/OpenSans.ttf', $username . ',');
imagettftext($img, 200, 0, 1600, 1625, $white, 'fonts/OpenSans.ttf', $testname);
imagettftext($img, 180, 0, 1600, 1976   , $white, 'fonts/OpenSans.ttf', $correct);
imagettftext($img, 180, 0, 1600, 2325, $white, 'fonts/OpenSans.ttf', $date);

// Возвращаем картинку
imagepng($img, 'img/result.png');
imagedestroy($img);