<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Patterns;

interface VehicleBuilderInterface
{
    function createVehicle();
    function addWheel();
    function addEngine();
    function addDoor();
    function getVehicle(): Vehicle;
}

abstract class Vehicle
{
    /**
     * @var Part[]
     */
    private $part = [];
    
    protected $type;
    
    function getType()
    {
        return $this->type; 
    }
    
    function setPart($key, $val)
    {
        $this->part[$key] = $val;
    }
    
    function getPart($key)
    {
        return $this->part[$key];
    }
}

abstract class Part
{
    protected $type;
    function getType()
    {
        return $this->type; 
    }
}

class Car extends Vehicle
{
    protected $type = 'car';
}

class Truck extends Vehicle
{
    protected $type = 'truck';
}

class Wheel extends Part
{
    protected $type = 'wheel';
}

class Engine extends Part
{
    protected $type='engine';
}

class Door extends Part
{
    protected $type='door';
}


/******/

class Director
{
    static function buildVehicle(VehicleBuilderInterface $builder): Vehicle
    {
        $builder->createVehicle();
        $builder->addWheel();
        $builder->addEngine();
        return $builder->getVehicle();
    }
}

class CarBuilder implements VehicleBuilderInterface
{
    private $car;
    
    function createVehicle()
    {
        $this->car = new Car();
    }
    
    function addWheel() 
    {
        $this->car->setPart('right_wheel', new Wheel);
        $this->car->setPart('left_wheel', new Wheel);
    }
    
    function addEngine() 
    {
        $this->car->setPart('engine', new Engine);
    }
    
    function addDoor() 
    {
        $this->car->setPart('right_door', new Door);
        $this->car->setPart('left_door', new Door);
    }
    
    function getVehicle(): Vehicle
    {
        return $this->car;
    }
}
