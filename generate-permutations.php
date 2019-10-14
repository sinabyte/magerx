<?php

$combinations = null;    
$data = null;

function createCombinations($elements, $k) {
    $n = sizeof($elements); 
    $num_permutations = pow($n, $k);
    $num_permutations_norepeat = gmp_fact($n)/gmp_fact($n - $k);
    $num_combinations = gmp_fact($n)/(gmp_fact($k)*gmp_fact($n - $k));
    echo "n: [".$n."] k: [".$k."] num_permutations: [".$num_permutations."] num_permutations_norepeat: [".$num_permutations_norepeat."] num_combinations: [".$num_combinations."]\n";

    global $combinations;
    global $data;
    $combinations = array();
    $data = array();
    combinationUtil($elements, $data, 0, $n - 1, 0, $k);
    shuffle($combinations);
    printf("%d combinations calculated\n", sizeof($combinations));
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