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

$linearDim = getOneDimArray($aDim);
sort($linearDim, SORT_NUMERIC);
$numEls = count($linearDim);
print_r($linearDim);

if (!($numEls % 2)) {
    // Четное число элементов массива, медиана равна полусумме двух средних соседних значений
    $median = ($linearDim[$numEls / 2] + $linearDim[$numEls / 2 - 1]) / 2;
    echo "Odd quantity";
} else {
    // Нечетное число элементов массива, медиана равна значению среднего элемента массива
    $median = $linearDim[$numEls / 2 + 1];
}
print_r($median);

$lessTwoTimes = array_search($median / 2, $linearDim);
$moreTwoTimes = array_search($median * 2, $linearDim);

var_dump($lessTwoTimes);
var_dump($moreTwoTimes);

$linearDim = array_splice($linearDim, $lessTwoTimes + 1);

print_r($linearDim);
