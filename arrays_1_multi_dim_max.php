<?php

$aDim = [
    87,
    356,
    2 => [
        4,
        6,
        7 => [-10, 19, 256, 59, 65,],
        8,
        9,
    ],
    3 => [54, 78, 95,],
    6 => [-7, 89, 176, 55,],
];

/**
 * @param array $arr
 * @param int $vMax
 * @return int
 */
function findMax(array $arr, int &$vMax): int
{
    foreach ($arr as $item) {
        if (is_array($item)) {
            $vMax = findMax($item, $vMax);
            continue;
        }
        if ($item > $vMax) {
            $vMax = $item;
        }
    }
    return $vMax;
}

$vMax = array_first($aDim);
var_dump(findMax($aDim, $vMax));
