<?php

$aDim = array(45,67,2 =>array(4, 6, 3 => array(-10, 19=>array(3,6,90,6),256, "first", 65), 8, 9),5 => array(54, "second", 95),7 => array(-7, "last", 176, 55),);

$linearDim = [];

function get_one_dim_array ($arr, $outDim)
{
    foreach ($arr as $item) {

        if (is_array($item)) {
            $outDim = get_one_dim_array($item,$outDim);
            continue;
        }
        elseif (is_numeric($item)){
            $outDim[] = $item;
        }

    }
    return $outDim;
}
print_r(get_one_dim_array($aDim,$linearDim));