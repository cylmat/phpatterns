<?php

/*
 * Encapsulates how a set of objects interact
 * "Talk with instead of talk to each others"
 * 
 * @see https://blog.ircmaxell.com/2012/03/handling-plugins-in-php.html
 */

namespace Phpatterns\Behavior;

interface MediatorInterface { public function runOrder(VehicleInterface $vehicle): string; public function stopOrder(VehicleInterface $vehicle): string; }
interface VehicleInterface { public function run(): string; public function stop(): string; }

class StationMediator implements MediatorInterface
{
    private $vehicles = [];
    
    public function runOrder(VehicleInterface $vehicle): string
    {
        $hash = \spl_object_hash($vehicle);
        !\key_exists($hash, $this->vehicles) ? $this->vehicles[$hash] = $vehicle : null;
        $vehicle = $this->vehicles[$hash];

        if ($vehicle->isRunningState) {
            return "Vehicle ".$vehicle->type." already running\n";
        } else {
            foreach ($this->vehicles as $v) {
                if ($v->isRunningState) {
                    return "Another vehicle ".$v->type." is already running\n";
                }
            }
        }
        
        return $vehicle->run();
    }
    
    public function stopOrder(VehicleInterface $vehicle): string
    {
        return $this->vehicles[\spl_object_hash($vehicle)]->stop();
    }
}

class Airplane implements VehicleInterface
{
    public $isRunningState = false;
    public $type = 'air';
    private $mediator;

    public function __construct(MediatorInterface $mediator)
    {
        $this->mediator = $mediator;
    }
    
    public function run(): string
    {
        $this->isRunningState = true;
        return $this->type." on the run\n";
    }
    
    public function stop(): string
    {
        $this->isRunningState = false;
        return $this->type." stopping\n";
    }
}

class Truck implements VehicleInterface
{
    public $isRunningState = false;
    public $type = 'truck';
    private $mediator;
    
    public function __construct(MediatorInterface $mediator)
    {
        $this->mediator = $mediator;
    }
    
    public function run(): string
    {
        $this->isRunningState = true;
        return $this->type." on the run\n";
    }
    
    public function stop(): string
    {
        $this->isRunningState = false;
        return $this->type." stopping\n";
    }
}

$mediator = new StationMediator();
$airplane = new Airplane($mediator);
$truck = new Truck($mediator);

$e = $mediator->runOrder($airplane);
$e .= $mediator->runOrder($airplane);
$e .= $mediator->runOrder($truck);

$e .= $mediator->stopOrder($airplane);
$e .= $mediator->runOrder($truck);

return (bool)preg_match('/truck on the run/', $e);
