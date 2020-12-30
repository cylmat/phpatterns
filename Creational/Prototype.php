<?php

namespace Patterns;

/**
 * Prototype
 */
abstract class Prototype
{
    public $g;

    /**
     * Constructor method
     */
    public function __construct() {

    }

    abstract public function __clone();

    public function getting($g)
    {
           $this->g = $g;
    }

}//end class

class Proto extends Prototype 
{
    public function __clone(){
        
    }
}
