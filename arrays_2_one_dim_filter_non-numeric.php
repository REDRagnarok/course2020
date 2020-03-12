<?php

$aDim = [
    45,
    67,
    2 => [
        4,
        6,
        3 => [
            -10,
            19 => [3, 6, 90, 6],
            256,
            "first",
            65,
        ],
        8,
        9,
    ],
    5 => [54, "second", 95,],
    7 => [-7, "last", 176, 55,],
];

/**
 * @param array $arr
 * @param array $outDim
 * @return array
 */
function getOneDimArray(array $arr, array $outDim = []): array
{
    foreach ($arr as $item) {
        if (is_array($item)) {
            $outDim = getOneDimArray($item, $outDim);
            continue;
        }
        if (is_numeric($item)) {
            $outDim[] = $item;
        }
    }
    return $outDim;
}

print_r(getOneDimArray($aDim));