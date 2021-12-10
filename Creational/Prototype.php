<?php

namespace Phpatterns\Creational;

abstract class Prototype
{
    public $g;

    public function __construct()
    {
    }

    abstract public function __clone();

    public function getting($g)
    {
           $this->g = $g;
    }

}

class Proto extends Prototype 
{
    public function __clone()
    { 
    }
}
