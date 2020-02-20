<?php

define('DS', DIRECTORY_SEPARATOR);
$cDir = __DIR__;
$cacheDir = $cDir . DS . '_cache';

if (!file_exists($cacheDir)) {
    if (!mkdir($cacheDir)) {
        die ('Не удалось создать директорию');
    }
}

// Копируем файлы в директорию '_cache'
$dh = opendir($cDir);
while ($entry = readdir($dh)) {
    $aFile = $cDir . DS . $entry;

    if (is_dir($aFile)) {
        continue;
    }

    if ($aFile === __FILE__) {
        continue;
    }

    if (pathinfo($aFile, PATHINFO_EXTENSION) === 'php') {
        copy($aFile, $cacheDir . DS . $entry);
    }
}
closedir($dh);
echo "Copying done!" . PHP_EOLs;

// Ищем файлы с include в каталоге '_cache'
$hasInclude = false;
$ch = opendir($cacheDir);
while ($entry = readdir($ch)) {
    $rFile = file($cacheDir . DS . $entry);
    $inclFound = preg_grep("/include '.*'/", $rFile); // Определяем наличие 'include' в файле
    if (empty($inclFound)) {
        continue;
    }

    $substDone = false;
    while (!empty($inclFound)) {
        $key = array_key_first($inclFound);
        $filename = explode("'", $inclFound[$key]); // Определяем имя подключаемого файла
        $filename = $cacheDir . DS . $filename[1];

        if (!file_exists($filename)) {
            echo "File to include not found!" . PHP_EOL;
            unset($inclFound[$key]);                        // Удаляем запись о ненайденном файле из массива
            continue;
        }

        $hasInclude = $substDone = true;
        echo "File to include " . $filename . PHP_EOL;

        $wFile = file($filename);
        unset($wFile[0]);   // Убираем тег '<?php' из начала файла
        array_splice($rFile, $key, 1, $wFile); // Производим замену 'include' содержимым файла
        $inclFound = preg_grep("/include '.*'/", $rFile); // Обновляем массив значений 'include'
    }

    if ($substDone) {   // Проверяем, производились ли замены.
        $fh = fopen($cacheDir . DS . $entry, 'w');
        foreach ($rFile as $line) {
            fwrite($fh, $line);
        }
        fclose($fh);
        echo "Search and replace  done!";
    }
}
closedir($ch);

if ($hasInclude === false) {
    echo "No files to include.\n";
}

//NOTE: за задание +++, можно кое где оптимизировать, например не пересматривать весь файл на include, а только добавляемые строки, также надо поработать над регулярками - они не сработают для html файлов внутри которых include, а по сути - это задание как раз на кеширование составных шаблонов
//NOTE: алгоритмическая ошибка - проверка переменной $substDone после цикла в котором она инициализируется - буде выведено занчение только для последней итерации