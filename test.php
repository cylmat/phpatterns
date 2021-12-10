<?php

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__)) as $dir) {
     include $dir->getRealpath();
}
