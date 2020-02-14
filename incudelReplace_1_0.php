<?php

echo '<pre>';
$cDir = __DIR__;
$sePar = DIRECTORY_SEPARATOR;
$nDir = $cDir.$sePar.'_cache';

if (!file_exists($nDir)){
    if (!mkdir($nDir)){
        die ('Не удалось создать директорию');
    }
}

// Копируем файлы в директорию '_cache'

$dh = opendir($cDir);
while (false !==($entry = readdir($dh))){

    $aFile = $cDir.$sePar.$entry;

    if (is_dir($aFile)){
        continue;
    }

    if ($aFile == __FILE__){
        continue;
    }

    if (pathinfo($aFile, PATHINFO_EXTENSION) == 'php'){
         copy($aFile,$nDir.$sePar.$entry);
    }
}
closedir($dh);
echo "Copying done!\n";

// Ищем файлы с include в каталоге '_cache'

$ch = opendir($nDir);
while (false !==($entry = readdir($ch))) {
    $substDone = false;
    $rFile = file($nDir.$sePar.$entry);
    $inclFound = preg_grep("/include '.*'/",$rFile); // Определяем наличие 'include' в файле
//    print_r($inclFound)."\n";

    while (!empty($inclFound)){

        $key = array_key_first($inclFound);
        $filename = explode("'",$inclFound[$key]); // Определяем имя подключаемого файла
        $filename = $nDir.$sePar.$filename[1];
//        echo $filename[1]."\n";
        if (file_exists($filename)) {
            echo "File to include ".$filename."\n";

            $wFile = file($filename);unset($wFile[0]);   // Убираем тег '<?php' из начала файла
            array_splice($rFile,$key,1,$wFile);
            $inclFound = preg_grep("/include '.*'/",$rFile); // Обновляем массив значений 'include'
        }
        else{                                               // Производим замену 'include' содержимым файла
            echo "File to include not found!\n";
            unset($inclFound[$key]);                        // Удаляем запись о ненайденном файле из массива
        }

        $substDone = true;
    }

    if ($substDone){                                        // Проверяем, производились ли замены.
        $fh = fopen($nDir.$sePar.$entry,'w');
        foreach($rFile as $line){
            fwrite($fh,$line);
        }
        fclose($fh);
        echo "Search and replace  done!";
    }
}
closedir($ch);
if ($substDone === false){
    echo "No files to include.\n";
}





