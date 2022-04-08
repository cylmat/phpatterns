<?php

namespace Phpatterns\Psr;

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
    public function isPropagationStopped(): bool { return false; } // not used for this demo
}

// responsible for determining what Listeners are relevant for a given Event
class ListenerProvider implements ListenerProviderInterface
{ 
    private $listeners = [];
    public function getListenersForEvent(object $event): iterable
    {
        if (\array_key_exists($name = get_class($event), $this->listeners)) {
            return $this->listeners[$name];
        }

        return [];
    }
    
    public function addListener(StoppableEventInterface $event, callable $callable): self
    {
        $this->listeners[$event::class][] = $callable;
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
            $listener($event);
        } 
    }
}

//  callable that expects to be passed an Event
class MyUserListener
{
    // Listener SHOULD have a void return
    public function __invoke(StoppableEventInterface $userEvent): void
    {
        $userEvent->data = "I'm listening to " . $userEvent->data;
    }
}

class MyUserListener2
{
    // Listener SHOULD have a void return
    public function __invoke(StoppableEventInterface $userEvent): void
    {
        $userEvent->data = $userEvent->data . " on that way";
    }
}

/*
 * Usage
 */
$userEvent = new MyPreUserEvent();
$userEvent->data = "Mr John's way";
$userListener = new MyUserListener();
$userListener2 = new MyUserListener2();

$listenerProvider = (new ListenerProvider())
    ->addListener($userEvent, $userListener)
    ->addListener($userEvent, $userListener2);
$dispatcher = new Dispatcher($listenerProvider);

// Emitter: arbitrary code that wishes to dispatch an Event (call the dispatcher)
$dispatcher->dispatch($userEvent);

return $userEvent->data === "I'm listening to Mr John's way on that way";
