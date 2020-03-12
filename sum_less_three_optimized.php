<?php

$aNum = 9;

$aStart = $aNum - 3;
if ($aNum % 3) {
    $aStart = $aNum - ($aNum % 3);
}

$sumThree = 0;
for ($i = $aStart; $i >= 3; $i -= 3) {
    $sumThree += $i;
}

echo 'Сумма кратных трем положительных чисел меньше ' . $aNum . ' равна ' . $sumThree;
