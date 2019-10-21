<?php

//
// usage: php ./generate-csv.php -k2 -nrock -v200
//

require('generate-permutations.php');
require('generate-util.php');

openFile($addProducts, 'C:\Users\Christopher\Downloads\export_catalog_product_20191004_110456.csv');

$myAdjectives = json_decode(file_get_contents("negative-advertising-adjectives.json"), true);
$k = (int)getopt("k:")["k"][0];
$productName = (string)getopt("n:")["n"];
$numVariants = (int)getopt("v:")["v"];

printf("name: %s variants: %d n: %s k: %s\n", $productName, number_format($numVariants), number_format((float)sizeof($myAdjectives)), (float)number_format($k));
printComboStats($myAdjectives, $k);

printf("calculating... ");
$starttime = microtime(true);
$combinations = createCombinations($myAdjectives, $k);
$endtime = microtime(true);
$timediff = $endtime - $starttime;
printf("%s combinations in %s seconds\n", number_format(sizeof($combinations)), $timediff);

shuffle($combinations);
foreach($combinations as $adjs) { shuffle($adjs); }

$storeProduct = (object)json_decode(file_get_contents("product.json"), true);
$addProducts = array();
for($i=0;$i<$numVariants; $i++) { 

    $sku = "";
    $name = "";    
    foreach($combinations[$i] as $adj) { 
        if ($sku == "") { $sku = $myAdjectives[$adj]; } else { $sku = $sku."-".$myAdjectives[$adj]; } 
        if ($name == "") { $name = $myAdjectives[$adj]; } else { $name = $name." ".$myAdjectives[$adj]; } 
    }        
    $sku = $sku."-".$productName;
    $name = $name." ".$productName;

    $qty = 100;
    $price = 1.0;

    $newProduct = clone $storeProduct;
    $newProduct->sku = $sku;
    $newProduct->name = $name;
    $newProduct->created_at = "10/4/19, 3:22 AM";
    $newProduct->updated_at = "10/4/19, 3:22 AM";
    $newProduct->qty = $qty;
    $newProduct->price = $price;
    
    array_push($addProducts, $newProduct);
}

saveFile($addProducts, "C:\Users\Christopher\Downloads\catalog_product - samplefile - out.csv");
printf("%d products ready\n", sizeof($addProducts));