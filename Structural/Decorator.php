<?php

/** Decorator: allows behavior to be added to an individual object at run-time*/

class DatabaseMapper{
    public function getData(array $array): array {
        return $array;
    }
    
    public function unchanged(): string {
        return 'ok';
    }
}

class MapperDecorator extends DatabaseMapper // get all existing methods from wrappee object
{
    private $wrappee;

    public function __construct(DatabaseMapper $mapper) { // allow specific object decoration
        $this->wrappee = $mapper;
    }
    
    public function getData(array $array): array { // "decorated" method
        return \array_merge($this->wrappee->getData($array), ['bonus']);
    }
}

$decorator = new MapperDecorator(new DatabaseMapper());
return "ok,1,2,3,bonus" === $decorator->unchanged() .','. join(',',$decorator->getData([1,2,3]));
