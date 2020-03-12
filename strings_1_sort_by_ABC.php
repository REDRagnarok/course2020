<?php

// Первый вариант
$unOrd = ["yard", "Festival", "lorem", "ipsum", "mountain", "serpent"];
$sorted = [];

foreach ($unOrd as $word) {
    $key = ord($word[0]);
    $sorted[$key] = $word;
}

ksort($sorted);
print_r($sorted);

//Второй вариант
sort($unOrd);
print_r($unOrd);