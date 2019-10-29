<?php

$inputFolder  = "C:\Users\Christopher\Desktop\sandbox\downloads\orange oranges citrus fruit-orange";
$images = scandir($inputFolder);
$images = array_filter($images, function ($var) { if (($var == ".") or ($var == "..")) return false; return true;} );
printf("found %d images\n", sizeof($images));

$outputFolder = $inputFolder.'-cropped';
if (!file_exists($outputFolder)) { mkdir($outputFolder); }    

foreach($images as $filename) {

    if ((strpos(strtolower($filename), '.jpeg') === false) && (strpos(strtolower($filename), '.jpg') === false)) { echo "not a jpeg\n"; continue; }
    $im1 = imagecreatefromjpeg($inputFolder."\\".$filename);
    if (!$im1) { echo "im1 error!\n"; continue; }

    $size = min(imagesx($im1), imagesy($im1));    
    $x = calc_x($im1);
    $y = calc_y($im1);
    $width = min(imagesx($im1), imagesy($im1));    
    $height = min(imagesx($im1), imagesy($im1));   

    $newfilename = urldecode($filename);
    $newfilename = preg_replace('/[^A-Za-z0-9._-]/','', $newfilename);
    $newfilename = $outputFolder.'\\'.$newfilename;

    echo "orig: [".$filename."] new: [".$newfilename."]\n";

    try {
        $im2 = imagecrop($im1, ['x' => $x, 'y' => $y, 'width' => $width, 'height' => $height ]);
        imagejpeg($im2, $newfilename);
        imagedestroy($im2);
    } finally  {
        imagedestroy($im1);
    }
}
printf("done!\n");

function calc_x($im1) {
    if (imagesx($im1) > imagesy($im1)) { return (imagesx($im1) - imagesy($im1)) / 2; }
    return 0;
}
function calc_y($im1) {
    if (imagesy($im1) > imagesx($im1)) { return (imagesy($im1) - imagesx($im1)) / 2; }
    return 0;
}