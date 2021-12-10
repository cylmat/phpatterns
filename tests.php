<?php

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__)) as $file) {
     if ('php' !== $file->getExtension()) {
         continue;    
     }
     echo 
         $file->getRealpath(),
         1 === (include $file->getRealpath()) ? ' ... ' : " ......... \t [OK] ",
         PHP_EOL;
}
