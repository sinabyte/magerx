<?php

$combinations = null;    
$data = null;

function printComboStats($elements, $k) {
    $n = sizeof($elements); 
    $num_permutations = pow($n, $k);
    $num_permutations_norepeat = gmp_fact($n)/gmp_fact($n - $k);
    $num_combinations = gmp_fact($n)/(gmp_fact($k)*gmp_fact($n - $k));
    printf("set n: %d subset k: %d combos: %s permute: %s unique: %s\n", $n, $k, number_format((float)$num_combinations), number_format((float)$num_permutations), number_format((float)$num_permutations_norepeat));
}

function createCombinations($elements, $k) {
    $n = sizeof($elements); 
    $num_permutations = pow($n, $k);
    $num_permutations_norepeat = gmp_fact($n)/gmp_fact($n - $k);
    $num_combinations = gmp_fact($n)/(gmp_fact($k)*gmp_fact($n - $k));
    global $combinations;
    global $data;
    $combinations = array();
    $data = array();
    combinationUtil($elements, $data, 0, $n - 1, 0, $k);
    return $combinations;
}

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