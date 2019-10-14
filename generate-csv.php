<?php
    
$qualifier = 'Apple';
$nameset = [ 'Moist', 'Chewy', 'Juicy', 'Healthy', 'Treat', 'Organic', 'Unsweetened', 'Crunchy', 'Vegan', 'Special', 'Excelsior', 'Spicy' ];
$size = 2;

MakeProducts($qualifier, $nameset, $size);

function MakeProducts($qualifier, $nameset, $size) {

    require('generate-permutations.php');
    $combinations = createCombinations($nameset, $size);
    shuffle($combinations);
    foreach($combinations as $combo) { shuffle($combo); }

    require('generate-util.php');
    $storeProduct = openFile();

    $addProducts = array();
    foreach($combinations as $combo) {

        $sku = "";
        $name = "";
        foreach($combo as $element) {
            if ($name != "") { $name = $name." "; }
            $name = $name.$nameset[$element];
            $sku = $sku.strtolower($nameset[$element]);
        }
        $sku = strtolower($qualifier)."-".$sku;
        $name .= " ".$qualifier;

        $qty = 100;

        $newProduct = clone $storeProduct;
        $newProduct->sku = $sku;
        $newProduct->name = $name;
        $newProduct->created_at = "10/4/19, 3:22 AM";
        $newProduct->updated_at = "10/4/19, 3:22 AM";
        $newProduct->qty = $qty;
        
        //printf("sku: %s name: %s\n", $sku, $name);
        array_push($addProducts, $newProduct);
    }    

    saveFile($addProducts);
}