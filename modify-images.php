<?php

require('generate-permutations.php');
require('generate-util.php');

$imageDirectory  = "C:\Users\Christopher\Desktop\sandbox\downloads\orange-orange-cropped";
$images = scandir($imageDirectory);
$images = array_filter($images, function ($var) { if (($var == ".") or ($var == "..")) return false; return true;} );
printf("found %d images\n", sizeof($images));

$myProducts = array();
$inputFilename = "C:\Users\Christopher\Downloads\catalog_product - samplefile - out.csv";
$storeProduct = openFile($myProducts, $inputFilename);

// work it.
shuffle($images);
shuffle($myProducts);
foreach($myProducts as $product) {
    $image_name = array_pop($images);
    printf("%s\n", $image_name);
    $product->base_image = $image_name;
    $product->base_image_label = "";
    $product->small_image = $image_name;
    $product->small_image_label = "";
    $product->thumbnail_image = $image_name;
    $product->thumbnail_image_label = "";
}

$outputFilename = "C:\Users\Christopher\Downloads\catalog_product - samplefile - IN.csv";
saveFile($myProducts, $outputFilename);