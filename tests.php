<?php

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__)) as $dir) {
     echo $dir->getRealpath().PHP_EOL;
     include $dir->getRealpath();
}
