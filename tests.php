<?php

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__)) as $file) {
     if ('php' !== $file->getExtension()) {
         continue;    
     }
     echo $file->getRealpath();
     if (!include_once $file->getRealpath()) { exit(1); }
     else echo " ......... \t [OK] ";
     echo PHP_EOL;
}
