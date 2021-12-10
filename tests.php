<?php

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__)) as $file) {
     if ('php' !== $file->getExtension()) {
         continue;    
     }
     echo $file->getRealpath();
     if (1 === (include_once $file->getRealpath())) die(' ... ');
     else echo " ......... \t [OK] ";
     echo PHP_EOL;
}
