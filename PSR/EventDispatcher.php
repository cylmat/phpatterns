<?php

/**
 * Event Dispatcher
 * - Inject logic into an application easily
 *
 * @see https://www.php-fig.org/psr/psr-14
 * 
 * - Event: communication between an Emitter and appropriate Listeners, lossless serialization and deserialization
 * - Listener: only one parameter, which is the Event
 * - Emitter: dispatch an Event
 * - Dispatcher: retrieving Listeners from a Listener Provider, and invoking each Listener with that Even
 * - Listener Provider: responsible for determining what Listeners are relevant (NOT call the Listeners itself)
 */

interface EventDispatcherInterface { public function dispatch(object $event); }
interface ListenerProviderInterface { public function getListenersForEvent(object $event): iterable; } // compatible with $event
interface StoppableEventInterface { public function isPropagationStopped(): bool; }

