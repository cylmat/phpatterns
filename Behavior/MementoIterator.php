<?php
// Your code here!

/**
 * iteration of memento
 */
class ClientOriginator 
{
    private $state = 'not started';
    
    function getState()
    {
        return $this->state;
    }
    
    function next()
    {
        if ('not started' == $this->state) {
            $this->state = 'processing';
        } elseif ('processing' == $this->state) {
            $this->state = 'delivering';
        } elseif ('delivering' == $this->state) {
            $this->state = 'end';
        } 
    }
    
    function save()
    {
        return $this->createMemento(); 
    }
    
    function restore(object $memento)
    {
        $this->state = $memento->getState($this);
        echo "restored...\n";
    }
    
    private function createMemento()
    {
        $memento = new class ($this, $this->state) {
            private $owner;
            private $state;
            private $public_state; //for iterator or others display
            function __construct(ClientOriginator $owner, string $state)
            { 
                $this->owner = $owner; 
                $this->state = $state; 
            }
            function getPublicState()
            {
                return $this->state . "<public>"; 
            }
            function getState(ClientOriginator $owner) 
            { 
                if($owner===$this->owner) 
                    return $this->state; 
                else { 
                    throw new \DomainException("Only access Memento from the owner"); 
                } 
            }
        };
        return $memento;
    }
}

class CareTaker
{
    private $stack;
    function addMemento(object $memento) 
    { 
        if ($this->stack===null) 
            $this->stack=new SplStack; 
        $this->stack->push($memento); 
    }
    function getLast() 
    { 
        if(!$this->stack->isEmpty()) 
            return $this->stack->pop(); 
    }
    // Iterator Pattern
    function getIterator()
    {
        return new class(clone $this->stack) { 
            private $stack;
            function __construct($stack) 
            {
                $this->stack = $stack;
            }
            function getNext()
            {
                return $this->stack->pop()->getPublicState();
            }
            function hasNext(): bool
            {
                return (!$this->stack->isEmpty());
            }
        };
    }
}

//ALLOWED
$client = new ClientOriginator;
$clientCare = new CareTaker;
$not_started = $client->save();
$clientCare->addMemento($not_started);
$client->next();
$client->next();

//iterator
$clientCare->addMemento($client->save());
$iterator = $clientCare->getIterator();
echo "Iterator: ";
while($iterator->hasNext()) {
    echo $iterator->getNext()." - ";
}
echo "\n";

//restore
echo "State1: ".$client->getState()."\n";
$client->restore($clientCare->getLast());
echo "State2: ".$client->getState()."\n";
$client->restore($not_started);
echo "State initial: ".$client->getState()."\n";

// OTHER
$not_started_other_client = (new ClientOriginator)->save();
try {
    $client->restore($not_started_other_client);
} catch(\DomainException $e) { echo "Exception launched, not allowed client\n"; }
echo $client->getState()."\n";