<?php

namespace Phpatterns\Creational;

class Prototype
{
    public $id;
    public $value;

    public function __construct()
    {
        // echo 'only one creation...'.PHP_EOL;
        $this->id = uniqId();
        $this->{'value'} = '9';
    }
    
    public function __clone()
    {
        // this will be the cloned object
        $this->id = uniqId('', true);
    }
}

$protos = [new Prototype];
foreach (range(0, 3) as $r) {
    $protos[] = clone $protos[0];
}

$hash1 = \spl_object_hash($protos[0]);
$hash2 = \spl_object_hash($protos[1]);

return ($hash1 !== $hash2) && ($protos[0]->id !== $protos[1]->id);
