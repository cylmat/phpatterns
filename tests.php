<?php

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__)) as $file) {
     if ('php' !== $file->getExtension()) {
         continue;    
     }
     echo 
         $file->getRealpath().PHP_EOL,
         1 === include $file->getRealpath() ? 'OK' : ' ... ',
         PHP_EOL;
}
