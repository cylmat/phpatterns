<?php

/*
 * Allow vary abstraction and implementation(s) independently
 * Have common with Adapter (two independents classes works together)
 *   when Bridge provides a stable interface to clients even as it lets you vary the classes that implement it
 * 
 * - Adapter pattern makes things work after they're designed; Bridge makes them work before they are.
 * 
 * e.g. 
 *   IAbstraction    -> UsedAbstraction1->operation()
 *                        call -> operationImplemented()
 *   IImplementation -> UsedImplementation1->operationImplemented()
 */

interface MessageSender // 1 abstraction for clients
{
    public function send(): string;
}

interface MessageComplexEngine // Multiple implementations
{
    public function sendEngineToSsl(): string;
}

///

class HtmlSender implements MessageSender 
{
    private $messageEngine;
    
    public function __construct(MessageComplexEngine $messageEngine)
    {
        $this->messageEngine = $messageEngine;
    }
    
    // like Adapter pattern
    public function send(): string
    {
        return $this->messageEngine->sendEngineToSsl();
    }
}

// Implementations

class TunnelingSender implements MessageComplexEngine
{
    public function sendEngineToSsl(): string
    {
        return 'Tunneling sender.';
    }
}

class DatabaseSender implements MessageComplexEngine
{
    public function sendEngineToSsl(): string
    {
        return 'Database sender.';
    }
}

class CryptedSender implements MessageComplexEngine
{
    public function sendEngineToSsl(): string
    {
        return 'Crypted sender.';
    }
}

// Same interface for every implementations

$htmlSender = new HtmlSender(new TunnelingSender());
$tunnel = $htmlSender->send();

$htmlSender = new HtmlSender(new DatabaseSender());
$database = $htmlSender->send();

$htmlSender = new HtmlSender(new CryptedSender());
$crypted = $htmlSender->send();

return 'Database sender.Crypted sender.' === $database.$crypted;
