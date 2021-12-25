<?php

/* 
 * Without violating encapsulation, capture and externalize an object’s internal state so that the object can be restored to this state later.
 * 
 * CaretakerInterface
 * OriginatorInterface: create, restore
 * MementoInterface: getState, setState
 * 
 * e.g. pseudo-random, finite state machine, "cancel" function
 */

namespace Phpatterns\Behavior;

// refers to the Originator class for saving (createMemento()) and restoring (restore(memento)) originator's internal state
interface CaretakerInterface { function addMemento(MementoInterface $memento): void; }
// creating and returning a Memento object that stores originator's current internal state 
interface OriginatorInterface { function save(): MementoInterface; function restore(MementoInterface $memento): void; }
// capture an internal state
interface MementoInterface { function getState(OriginatorInterface $owner); }

class ClientOriginator implements OriginatorInterface
{
    private $state = 'not started';
    
    function getState() { return $this->state; }
    
    function next()
    {
        switch ($this->state) {
            case 'not started': $this->state = 'processing'; break;
            case 'processing': $this->state = 'delivering'; break;
            case 'delivering': $this->state = 'ending'; break;
        }
    }
    
    // Create memento
    function save(): MementoInterface
    {
        return new class ($this->state, $this) implements MementoInterface {
            private $owner;
            private $state;
    
            function __construct(string $state, ClientOriginator $owner)
            { 
                $this->owner = $owner; 
                $this->state = $state; 
            }
            
            function getState(OriginatorInterface $owner): string
            { 
                // Security to allowed only own memento object
                if ($owner === $this->owner)
                    return $this->state;
                else { 
                    throw new \DomainException("Only access Memento from the owner"); 
                } 
            }
        };
    }
    
    function restore(MementoInterface $memento): void
    {
        $this->state = $memento->getState($this);
    }
}

class CareTaker implements CaretakerInterface
{
    private $stack;
    function addMemento(MementoInterface $memento): void
    { 
        if (null === $this->stack) 
            $this->stack = new \SplStack(); 
        $this->stack->push($memento); 
    }
    
    function getLast() { return $this->stack->pop(); }
}

$client = new ClientOriginator;
$clientCare = new CareTaker;
$not_started = $client->save();
$clientCare->addMemento($not_started);
$client->next();
$client->next();

$client->restore($clientCare->getLast());
$client->restore($not_started);

return 'not started' === $client->getState();
