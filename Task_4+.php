<?php

function searchPhp ($dir):array // Рекурсивный обход каталогов, поиск файлов с расширением php
{
    $list = array_diff(scandir($dir), ['.', '..']); // Выкидываем указатели на текущий и вышестоящий каталог
    $result = [];
    foreach ($list as $item) {
        $path = $dir.DIRECTORY_SEPARATOR.$item;
        if (is_dir($path)) {
            $result = array_merge($result,searchPhp($path));
        }
        else {
            $ext = explode('.',$item);// Просмотр расширения файла
            if ($ext[1] == 'php'){
                $result[] = $path;
            }
        }
    }
    return $result;
}

function searchInclude($dir):array // Поиск файлов с вхождением 'include' и замена
{
    $includeFound=[];
    $list = array_diff(scandir($dir), ['.', '..']); // Листинг директории, отбрасываем '.' и '..'
    foreach ($list as $file){
        $content = file($file);
        foreach ($content as $key => $line){
            $phrase = strpos($line,'include');
            if (is_numeric($phrase)){ // Замена на содержимое файла в 'include'
                $elm = explode ("'",$line);
                $insFile = file($elm[1]);
                unset ($insFile[0]);
                array_splice($content,$key,1,$insFile);
            }
        }
        $fp = fopen($file,'w'); //Перезапись модиф.файла
        foreach($content as $str){
            fwrite($fp,$str);
        }
        fclose($fp);
    }
    return $includeFound;
}

echo '<pre>';
$selected = searchPhp( __DIR__); // Поиск и вывод на экран файлов с расширением php
print_r($selected);

foreach ($selected as $file){ // Копирование php-файлов из корневого каталога в '/_cache'
    $isRoot = dirname($file,1); // Предполагается что каталог уже создан
    $name = basename($file);
    if ($isRoot == __DIR__){
       copy($file,$isRoot.DIRECTORY_SEPARATOR."_cache".DIRECTORY_SEPARATOR.$name);
    }
}
searchInclude(__DIR__.DIRECTORY_SEPARATOR.'_cache'); // Поиск 'include' в скопированныйх в '/_cache' файлах
// и вставка содержимого 'include' файлов