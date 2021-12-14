<?php

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__)) as $file) {
     if ('php' !== $file->getExtension()) {
         continue;    
     }
     echo $file->getRealpath();
     if (true !== include_once $file->getRealpath()) { echo "File doesn't return true".PHP_EOL; exit(1); }
     else echo " ......... \t [OK] ";
     echo PHP_EOL;
}
