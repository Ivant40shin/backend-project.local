<?php
session_start();

// Создаем случайную строку для CAPTCHA
$captcha_text = substr(md5(uniqid(rand(), true)), 0, 6);
$_SESSION['captcha'] = $captcha_text;

$width = 100;
$height = 50;
$image = imagecreatetruecolor($width, $height);

$bg_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
$line_color = imagecolorallocate($image, 200, 200, 200);

imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);

for ($i = 0; $i < 5; $i++) {
    imageline($image, 0, rand() % $height, $width, rand() % $height, $line_color);
}

$font = 5;
$x = 10 + rand(0, 20);
$y = 20 + rand(0, 10);
imagestring($image, $font, $x, $y, $captcha_text, $text_color);

header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>