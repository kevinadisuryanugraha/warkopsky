<?php
// generate_og.php

$width = 1200;
$height = 630;
$im = imagecreatetruecolor($width, $height);

// Colors
$bg = imagecolorallocate($im, 10, 15, 29); // #0A0F1D
$white = imagecolorallocate($im, 255, 255, 255);
$gold = imagecolorallocate($im, 255, 200, 87); // #FFC857 (Brand Warm Gold)

// Fill background
imagefill($im, 0, 0, $bg);

// Add subtle grain/noise texture overlay
for ($i = 0; $i < 40000; $i++) {
    $x = rand(0, $width);
    $y = rand(0, $height);
    $alpha = rand(110, 126);
    $noise_color = imagecolorallocatealpha($im, 255, 255, 255, $alpha);
    imagesetpixel($im, $x, $y, $noise_color);
}

// Find a suitable system font on Windows (Georgia Bold matches the serif display aesthetic)
$fontPath = 'C:\\Windows\\Fonts\\georgiab.ttf';
if (!file_exists($fontPath)) {
    $fontPath = 'C:\\Windows\\Fonts\\arial.ttf';
}

if (file_exists($fontPath)) {
    // Center Text: "Warkop Sky" - 72px (GD points scale ~ 54pt)
    $fontSize1 = 54; 
    $text1 = "Warkop Sky";
    $bbox1 = imagettfbbox($fontSize1, 0, $fontPath, $text1);
    $textWidth1 = $bbox1[2] - $bbox1[0];
    $x1 = ($width - $textWidth1) / 2;
    $y1 = 290;
    imagettftext($im, $fontSize1, 0, $x1, $y1, $white, $fontPath, $text1);

    // Subtext: "Ngopi 24 Jam di Bawah Langit Jatiasih" - 32px (~ 24pt)
    $fontSize2 = 24; 
    $text2 = "Ngopi 24 Jam di Bawah Langit Jatiasih";
    $bbox2 = imagettfbbox($fontSize2, 0, $fontPath, $text2);
    $textWidth2 = $bbox2[2] - $bbox2[0];
    $x2 = ($width - $textWidth2) / 2;
    $y2 = 380;
    imagettftext($im, $fontSize2, 0, $x2, $y2, $gold, $fontPath, $text2);
} else {
    // Fallback if no TTF font is found on path
    $text1 = "Warkop Sky";
    $text2 = "Ngopi 24 Jam di Bawah Langit Jatiasih";
    imagestring($im, 5, ($width - strlen($text1)*9)/2, 250, $text1, $white);
    imagestring($im, 5, ($width - strlen($text2)*9)/2, 330, $text2, $gold);
}

// Ensure target directory exists
if (!is_dir(__DIR__ . '/public/images')) {
    mkdir(__DIR__ . '/public/images', 0755, true);
}

// Save image as JPG
imagejpeg($im, __DIR__ . '/public/images/og-default.jpg', 90);
imagedestroy($im);

echo "OG Image generated successfully at public/images/og-default.jpg!\n";
