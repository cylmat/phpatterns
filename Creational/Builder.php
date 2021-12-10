<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Phpatterns\Creational;

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
    /** @var string */
    protected $type;
    /** @var Part[] */
    private $parts = [];
    
    function getType(): string { return $this->type; }
    
    function setPart(string $key, string $val) { $this->parts[$key] = $val; }
    
    function getPart($key): string { return $this->parts[$key]; }
}

abstract class Part
{
    /** @var string */
    protected $type;

    function getType(): string { return $this->type; }
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
    protected $type = 'engine';
}

class Door extends Part
{
    protected $type = 'door';
}

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
    /** @var Vehicle */
    private $car;
    
    public function createVehicle() { $this->car = new Car(); }
    
    public function getVehicle(): Vehicle { return $this->car; }    
    
    function addWheel(): void
    {
        $this->car->setPart('right_wheel', new Wheel);
        $this->car->setPart('left_wheel', new Wheel);
    }
    
    function addEngine(): void
    {
        $this->car->setPart('engine', new Engine);
    }
    
    function addDoor(): void
    {
        $this->car->setPart('right_door', new Door);
        $this->car->setPart('left_door', new Door);
    }
}

