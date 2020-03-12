<?php

$gibberish = "AAbBbbCcCcAAa";

$letter = 0;
while ($letter < strlen($gibberish)) {
    $subst = $gibberish[$letter];
    $gibberish = preg_replace("/" . quotemeta($subst) . "+/", $subst, $gibberish);
//    $gibberish = preg_replace("/$subst+/i","$subst",$gibberish); //Регистронезависимый вариант
    $letter++;
}
print_r($gibberish);







