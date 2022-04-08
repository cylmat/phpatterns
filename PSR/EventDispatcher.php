<?php

/**
 * Event Dispatcher PSR-14
 * - Inject logic into an application easily
 *
 * @see https://www.php-fig.org/psr/psr-14
 * @see https://dev.to/fadymr/php-create-your-own-php-psr-14-event-dispatcher-200b
 * 
 * - Event: communication between an Emitter and appropriate Listeners, lossless serialization and deserialization
 * - Listener: only one parameter, which is the Event
 * - Emitter: Given an Event object by an Emitter, dispatch an Event, the "calling code"
 * - Dispatcher: retrieving Listeners from a Listener Provider, and invoking each Listener with that Even
 * - Listener Provider: responsible for determining what Listeners are relevant (NOT call the Listeners itself)
 * 
 * interface EventDispatcherInterface { public function dispatch(object $event); }
 * interface ListenerProviderInterface { public function getListenersForEvent(object $event): iterable; } // compatible with $event
 * interface StoppableEventInterface { public function isPropagationStopped(): bool; }
 */

interface EventDispatcherInterface { public function dispatch(object $event); }
interface ListenerProviderInterface { public function getListenersForEvent(object $event): iterable; } // iterable compatibles with $event
interface StoppableEventInterface { public function isPropagationStopped(): bool; }

// message produced by an Emitter
class MyPreUserEvent implements StoppableEventInterface
{
    public $data;
    public function isPropagationStopped() { return false; } // not used for this demo
}

// responsible for determining what Listeners are relevant for a given Event
class ListenerProviderInterface implements ListenerProviderInterface
{ 
    private $listeners = [];
    public function getListenersForEvent(object $event): iterable
    {
        foreach ($this->listeners as $eventName => $listeners) {
            
        }
    }
    
    public function addListener(string $eventName, callable $callable): self
    {
        $this->listeners[$eventName][] = $callable;
        return $this;
    }
}

// service object that is given an Event object by an Emitter
class Dispatcher implements EventDispatcherInterface
{
    private $provider;
    public function __construct(ListenerProviderInterface $provider) { $this->provider = $provider; }
    
    public function dispatch(object $event)
    {
        foreach ($this->provider->getListenersForEvent($event) as $listener) {
            $listener();
        } 
    }
}

//  callable that expects to be passed an Event
class MyUserListener
{
    public function __invoke(StoppableEventInterface $userEvent)
    {
        return "I'm listening to ".$userEvent->data;
    }
}

/*
 * Usage
 */
$event = new MyPreUserEvent();
$event->data = "Mr John's user";

$listenerProvider = (new ListenerProvider())
    ->addListener(Event::class, new UserListener());
$dispatcher = new EventDispatcher($listenerProvider);

// Emitter: arbitrary code that wishes to dispatch an Event (call the dispatcher)
$dispatcher->dispatch(new MyPreUserEvent($user));
