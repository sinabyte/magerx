<?php

    $inputFilename = 'C:\Users\Christopher\Downloads\export_catalog_product_20191004_143005.csv';
    $csv = file_get_contents($inputFilename);
    $array1 = explode("\n", $csv);    
    $array2 = array_map("str_getcsv", $array1);
    $storeProduct = null; 
    $indexToKey = array();

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
        }
    }    
    /*
    * nCk - pick k from n
    */
    $catName = "Bowling Ball";
    $names = [
        "Deadeye"
        ,"Splitter"
        ,"Sphere"
        ,"Glitter"
        ,"Heavy"
        ,"Crusher"
        ,"PinBuster"
        ,"LaneSplitter"
        ,"Jesus"
        ,"Lebowski"
        ,"Superior"
        ];
        // $catName = "Fly Swatter";
        // $names = [
        //     "Slappy"
        //     ,"Slapshot"
        //     ,"Splat"
        //     ,"Superior"
        //     ,"Red"
        //     ,"Slapaholic"
        //     ,"Green"
        //     ,"Blue"
        //     ,"Black"
        //     ,"Tough"
        //     ,"Superior"
        //     ];
            // $catName = "Apple";
        // $names = [
        //     "Freedom"
        //     ,"Bliss"
        //     ,"Crisp"
        //     ,"Decadent"
        //     ,"Gala"
        //     ,"Glee"
        //     ,"Granny"
        //     ,"Green"
        //     ,"Jazz"
        //     ,"Rebel"
        //     ,"Juicy"
        //     ,"Lady"
        //     ,"Organic"
        //     ,"Pink"
        //     ,"Red"
        //     ,"Vegan"
        //     ,"Sinful"
        //     ,"Wicked"
        //     ,"Wet"
        //     ,"Gay"
        //     ,"Sassy"
        //     ,"Sweet"
        //     ,"Sour"
        //     ,"Wild"
        //     ,"Retro"
        //     ,"Future"
        //     ,"Patriot"
        //     ];
        $elements = $names;
    $n = sizeof($elements); 
    $k = 2;
    $num_permutations = pow($n, $k);
    $num_permutations_norepeat = gmp_fact($n)/gmp_fact($n - $k);
    $num_combinations = gmp_fact($n)/(gmp_fact($k)*gmp_fact($n - $k));
    echo "n: [".$n."] k: [".$k."] num_permutations: [".$num_permutations."] num_permutations_norepeat: [".$num_permutations_norepeat."] num_combinations: [".$num_combinations."]\n";

    // generate all combinations
    $combinations = array();    
    $data = array();
    combinationUtil($elements, $data, 0, $n - 1, 0, $k);     
    $max = sizeof($combinations);
    echo $max." combinations calculated\n";
    shuffle($combinations);

    // $imageList = 'C:\Users\Christopher\Desktop\sandbox\downloads\banana.parse.txt';
    // $imageList = 'C:\Users\Christopher\Desktop\sandbox\downloads\Fly Swatter.parse.txt';
    $imageList = 'C:\Users\Christopher\Desktop\sandbox\downloads\bowling ball.parse.txt';
    $lines = file($imageList, FILE_IGNORE_NEW_LINES);
    shuffle($lines);

    $maxfiles = sizeof($lines);
    echo $maxfiles." files available\n";

    $index = 0;
    $addProducts = array();
    for ($i=0; $i<$max; $i++) {

        $newProduct = clone $storeProduct;

        $newProduct->store_view_code = "";
        $newProduct->attribute_set_code = "Default";
        $newProduct->product_type = "simple";
        // $newProduct->categories = "Default Category/Fruit/Apples";
        // $newProduct->categories = "Default Category/Fly Swatters";
        $newProduct->categories = "Default Category/Bowling Balls";
        $newProduct->product_websites = "base";

        $lookup = array_pop($combinations);
        //$sku = "fruit-".$catName."-";
        //$sku = "flyswatter-";
        $sku = "bowlingball-";
        $name = "";
        for ($j=0; $j<$k; $j++) {
            if ($name != "") $name = $name." ";
            $name = $name.$elements[$lookup[$j]];
            $sku = $sku.$elements[$lookup[$j]];
        }
        $sku = strtolower($sku);
        $newProduct->sku = $sku;
        $newProduct->name = $name." ".$catName;

        $newProduct->description = "";
        $newProduct->short_description = "";
        $newProduct->weight = "";
        $newProduct->product_online = 1;
        $newProduct->tax_class_name = "Taxable Goods";
        $newProduct->visibility = "Catalog, Search";        
        $newProduct->price = 0.99;
        $newProduct->special_price = "";
        $newProduct->special_price_from_date = "";
        $newProduct->special_price_to_date = "";
        $newProduct->url_key = $newProduct->sku;
        $newProduct->meta_title = $newProduct->sku;
        $newProduct->meta_keywords = $newProduct->sku;
        $newProduct->meta_description = $newProduct->sku;
        $newProduct->base_image = "";   //"no_selection";
        $newProduct->base_image_label = "";

        $small_image = array_pop($lines);
        $newProduct->small_image = $small_image;
        $newProduct->small_image_label = "";

        $newProduct->thumbnail_image = "";  //"no_selection";
        $newProduct->thumbnail_image_label = "";
        $newProduct->swatch_image = ""; //"no_selection";
        $newProduct->swatch_image_label = "";        
        $newProduct->created_at = "10/4/19, 3:22 AM";
        $newProduct->updated_at = "10/4/19, 3:22 AM";
        $newProduct->display_product_options_in = "Block after Info Column";
        $newProduct->gift_message_available = "Use config";
        $newProduct->msrp_display_actual_price_type = "Use config";
        $newProduct->additional_attributes = "product_image_size=Default,product_page_type=Default,sw_featured=No";
        $newProduct->qty = rand(3, 100);
        $newProduct->out_of_stock_qty = "0";
        $newProduct->use_config_min_qty = "1";
        $newProduct->is_qty_decimal = "0";
        $newProduct->allow_backorders = "0";
        $newProduct->use_config_backorders = "1";
        $newProduct->min_cart_qty = "1";
        $newProduct->use_config_min_sale_qty = "1";
        $newProduct->max_cart_qty = "1000";
        $newProduct->use_config_max_sale_qty = "1";
        $newProduct->is_in_stock = "1";
        $newProduct->notify_on_stock_below = "1";
        $newProduct->use_config_notify_stock_qty = "1";
        $newProduct->manage_stock = "1";
        $newProduct->use_config_manage_stock = "1";
        $newProduct->use_config_qty_increments = "1";
        $newProduct->qty_increments = "1";
        $newProduct->use_config_enable_qty_inc = "1";
        $newProduct->enable_qty_increments = "0";
        $newProduct->is_decimal_divided = "0";
        $newProduct->website_id = "0";

        array_push($addProducts, $newProduct);
        $index = $index + 1;
        //if ($index == 1) exit();
    }

    $outputFilename = "C:\Users\Christopher\Downloads\catalog_product - samplefile - out.csv";
    $outputFile = fopen($outputFilename, 'a+');
    fputs($outputFile, arrayToCsv($indexToKey, ',', '"', false, false)."\n");
    foreach($addProducts as $product) {
        $product = (array)$product;
        fputs($outputFile, arrayToCsv($product, ',', '"', false, false)."\n");
    }
    fclose($outputFile);    

// arr[]       ---> Input Array 
// data[]      ---> Temporary array to store current combination 
// start & end ---> Staring and Ending indexes in arr[] 
// index       ---> Current index in data[] 
// r           ---> Size of a combination to be printed 
function combinationUtil($arr, $data, $start, $end, $index, $r) { 
	// Current combination is ready to be printed, print it 
	if ($index == $r) 
	{ 
        global $combinations;
        array_push($combinations, array());
        for ($j = 0; $j < $r; $j++) 
            array_push($combinations[sizeof($combinations) - 1], $data[$j]);
		return; 
	} 
	// replace index with all possible elements. The condition "end-i+1 >= r-index" makes sure that including one element at 
	// index will make a combination with remaining elements at remaining positions 
	for ($i = $start; $i <= $end && $end - $i + 1 >= $r - $index; $i++) { 
		$data[$index] = $i; 
		combinationUtil($arr, $data, $i + 1, $end, $index + 1, $r); 
	} 
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