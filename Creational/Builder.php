<?php

namespace Phpatterns\Creational;

interface VehicleBuilderInterface
{
    public function createVehicle(): void;
    public function getVehicle(): Vehicle;
    public function addWheel(): void;
    public function addEngine(): void;
    public function addDoor(): void;
}

abstract class Vehicle
{
    /** @var string */
    protected $type;
    /** @var Part[] */
    private $parts = [];
    
    public function getType(): string { return $this->type; }
    
    public function setPart(string $key, Part $part) { $this->parts[$key] = $part; }
    
    public function getPart($key): Part { return $this->parts[$key]; }
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

class CarBuilder implements VehicleBuilderInterface
{
    /** @var Vehicle */
    private $car;
    
    public function createVehicle(): void { $this->car = new Car(); }
    
    public function getVehicle(): Vehicle { return $this->car; }    
    
    public function addWheel(): void
    {
        $this->car->setPart('right_wheel', new Wheel);
        $this->car->setPart('left_wheel', new Wheel);
    }
    
    public function addEngine(): void
    {
        $this->car->setPart('engine', new Engine);
    }
    
    public function addDoor(): void
    {
        $this->car->setPart('right_door', new Door);
        $this->car->setPart('left_door', new Door);
    }
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

// main
$vehicle = Director::buildVehicle(new CarBuilder());
return $vehicle->getPart('right_wheel')->getType() === 'door';
