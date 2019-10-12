<?php

$outputFolder = 'C:\Users\Christopher\Desktop\sandbox\downloads\images';
if (!file_exists($outputFolder)) { mkdir($outputFolder); }    
$imageList = 'C:\Users\Christopher\Desktop\sandbox\downloads\bowling ball.download.txt.txt';
// $imageList = 'C:\Users\Christopher\Desktop\sandbox\downloads\Fly Swatter.download.txt.txt';
// $imageList = 'C:\Users\Christopher\Desktop\sandbox\downloads\banana.download.txt.txt';
$lines = file($imageList, FILE_IGNORE_NEW_LINES);

$newImages = 'C:\Users\Christopher\Desktop\sandbox\downloads\bowling ball.parse.txt';
// $newImages = 'C:\Users\Christopher\Desktop\sandbox\downloads\Fly Swatter.parse.txt';
// $newImages = 'C:\Users\Christopher\Desktop\sandbox\downloads\banana.parse.txt';
$f = fopen($newImages, "w");

$index = 0;
foreach($lines as $line) {

    $filename = explode("\t", $line)[0];
    echo $filename."\n";

    $im1 = imagecreatefromjpeg($filename);
    if ($im1) {
        $size = min(imagesx($im1), imagesy($im1));    
        $im2 = imagecrop($im1, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size ]);

        $name = explode("/", $filename)[2];
        $name = substr($name, strpos($name, ".") + 1);

        $dest = $outputFolder."\\".substr($name, 0, 1);
        if (!file_exists($dest)) { mkdir($dest); }    
        $dest = $dest."\\".substr($name, 1, 1);
        if (!file_exists($dest)) { mkdir($dest); }    

        $qualified = $dest."\\".$name;    
        echo $qualified."\n";
        $tmp = substr($name, 0, 1)."/".substr($name, 1, 1)."/".$name;
        fwrite($f, $tmp."\n");

        imagejpeg($im2, $qualified);
        imagedestroy($im2);
        imagedestroy($im1);
    } else {
        echo "im1 error!\n";
    }
    $index = $index + 1;
    //if ($index == 2) exit();
}