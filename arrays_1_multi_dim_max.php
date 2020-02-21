<?php
$aDim = array(87,356,2 => array(4,6,
                        7 => array(-10,19,256,59,65)
                        ,8,9,),
                        3 => array(54,78,95),
                        6 => array(-7,89,176,55),);

$vMax = array_key_first($aDim);

function findMax ($arr,&$vMax){
    foreach ($arr as $item){
        if (is_array($item)){
            $vMax = findMax($item,$vMax);
            continue;
        }
        if ($item > $vMax){
            $vMax = $item;
        }
    }
    return $vMax;
}

var_dump(findMax($aDim,$vMax));
