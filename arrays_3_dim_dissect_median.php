<?php

$aDim = array(45, 67, 2 => array(4, 6, 3 => array(-10, 19 => array(3, 27, 90, 6), 256, "first", 65), 8), 5 => array(54, "second", 95), 7 => array(-7, "last", 176, 55),);



function get_one_dim_array($arr, $outDim)
{
    foreach ($arr as $item) {

        if (is_array($item)) {
            $outDim = get_one_dim_array($item, $outDim);
            continue;
        } elseif (is_numeric($item)) {
            $outDim[] = $item;
        }

    }
    return $outDim;
}

$linearDim = [];

$linearDim = get_one_dim_array($aDim, $linearDim);
sort($linearDim,SORT_NUMERIC);
$numEls =count($linearDim);
print_r($linearDim);

// Четное число элементов массива, медиана равна полусумме двух средних соседних значений
if (!($numEls%2)){
    $median = ($linearDim[$numEls/2]+$linearDim[$numEls/2-1])/2;
    echo "Odd quantity";
}
// Нечетное число элементов массива, медиана равна значению среднего элемента массива
else{
    $median = $linearDim[$numEls/2+1];
}
print_r($median);

$lessTwo_times = array_search($median/2,$linearDim);
$moreTwo_times = array_search($median*2,$linearDim);

var_dump($lessTwo_times);
var_dump($moreTwo_times);

$linearDim = array_splice($linearDim,$lessTwo_times+1);

print_r($linearDim);
