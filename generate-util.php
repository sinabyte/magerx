<?php

$indexToKey = array();

    //     //$imageList = 'C:\Users\Christopher\Desktop\sandbox\downloads\bowling ball.parse.txt';
    //     //$lines = file($imageList, FILE_IGNORE_NEW_LINES);
    //     //shuffle($lines);
    //     //$maxfiles = sizeof($lines);
    //     //echo $maxfiles." files available\n";
    
function saveFile($addProducts) {
    global $indexToKey;
    $outputFilename = "C:\Users\Christopher\Downloads\catalog_product - samplefile - out.csv";
    $outputFile = fopen($outputFilename, 'a+');
    fputs($outputFile, arrayToCsv($indexToKey, ',', '"', false, false)."\n");
    exit();
    foreach($addProducts as $product) {
        $product = (array)$product;
        fputs($outputFile, arrayToCsv($product, ',', '"', false, false)."\n");
    }
    fclose($outputFile);    
}
function openFile() {

    global $indexToKey;
    $inputFilename = 'C:\Users\Christopher\Downloads\export_catalog_product_20191004_143005.csv';
    printf("opening file %s\n", $inputFilename);
    $csv = file_get_contents($inputFilename);
    $array1 = explode("\n", $csv);    
    $array2 = array_map("str_getcsv", $array1);
    $indexToKey = array();
    $storeProduct = null;
    
    $count = 0;
    foreach($array2 as $importProduct) {
        $index = 0;
        if ($storeProduct == null) {
            $storeProduct = new stdClass();
            foreach($importProduct as $key) {
                $indexToKey[$index] = $key;
                $storeProduct->$key = '';
                $index = $index + 1;
            }
        } else {
            $newProduct = clone $storeProduct;
            foreach($importProduct as $value) {
                $key = $indexToKey[$index];
                $newProduct->$key = $value;
                $index = $index + 1;
            }
            $newProduct = (array)$newProduct;
            $count++;
        }
    }    
    printf("found %d records\n", $count);
    $storeProduct->store_view_code = "";
    $storeProduct->attribute_set_code = "Default";
    $storeProduct->product_type = "simple";
    $storeProduct->categories = "Default Category";
    $storeProduct->product_websites = "base";
    $storeProduct->description = "";
    $storeProduct->short_description = "";
    $storeProduct->weight = "";
    $storeProduct->product_online = 1;
    $storeProduct->tax_class_name = "Taxable Goods";
    $storeProduct->visibility = "Catalog, Search";        
    $storeProduct->special_price = "";
    $storeProduct->special_price_from_date = "";
    $storeProduct->special_price_to_date = "";
    $storeProduct->base_image = "";   
    $storeProduct->base_image_label = "";
    $storeProduct->small_image_label = "";
    $storeProduct->thumbnail_image = ""; 
    $storeProduct->thumbnail_image_label = "";
    $storeProduct->swatch_image = ""; 
    $storeProduct->swatch_image_label = "";        
    $storeProduct->display_product_options_in = "Block after Info Column";
    $storeProduct->gift_message_available = "Use config";
    $storeProduct->msrp_display_actual_price_type = "Use config";
    $storeProduct->additional_attributes = "product_image_size=Default,product_page_type=Default,sw_featured=No";
    $storeProduct->out_of_stock_qty = "0";
    $storeProduct->use_config_min_qty = "1";
    $storeProduct->is_qty_decimal = "0";
    $storeProduct->allow_backorders = "0";
    $storeProduct->use_config_backorders = "1";
    $storeProduct->min_cart_qty = "1";
    $storeProduct->use_config_min_sale_qty = "1";
    $storeProduct->max_cart_qty = "1000";
    $storeProduct->use_config_max_sale_qty = "1";
    $storeProduct->is_in_stock = "1";
    $storeProduct->notify_on_stock_below = "1";
    $storeProduct->use_config_notify_stock_qty = "1";
    $storeProduct->manage_stock = "1";
    $storeProduct->use_config_manage_stock = "1";
    $storeProduct->use_config_qty_increments = "1";
    $storeProduct->qty_increments = "1";
    $storeProduct->use_config_enable_qty_inc = "1";
    $storeProduct->enable_qty_increments = "0";
    $storeProduct->is_decimal_divided = "0";
    $storeProduct->website_id = "0";
    return $storeProduct;
}
/**
 * Formats a line (passed as a fields  array) as CSV and returns the CSV as a string.
 * Adapted from http://us3.php.net/manual/en/function.fputcsv.php#87120
 */
function arrayToCsv( array &$fields, $delimiter = ';', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false ) {
    $delimiter_esc = preg_quote($delimiter, '/');
    $enclosure_esc = preg_quote($enclosure, '/');    
    $output = array();
    foreach ( $fields as $field ) {
        if ($field === null && $nullToMysqlNull) {
            $output[] = 'NULL';
            continue;
        }    
        // Enclose fields containing $delimiter, $enclosure or whitespace
        if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
            $output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
        }
        else {
            $output[] = $field;
        }
    }    
    return implode( $delimiter, $output );
}