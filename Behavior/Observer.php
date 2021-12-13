<?php

namespace Phpatterns\Behavior;

class ErrorSubject implements \SplSubject // attach(obs), detach(obs), notify
{
    private $obs = [];
    private $notice;
    
    function attach(\SplObserver $splObserver): self { $this->obs[] = $splObserver; return $this; }
    function detach(\SplObserver $splObserver) { /** */ }
    function notify() { foreach($this->obs as $obs){ $obs->update($this); } }
    function getNotice() { return $this->notice; }

    function handle(int $errno, string $msg)
    { 
        $this->notice = "Error n° $errno: $msg".PHP_EOL;
        $this->notify();
    }
};

class EmailObserver implements \SplObserver // update(subject)
{
    public $txt;
    private $type;
    function __construct($type) { $this->type = $type; }
    
    function update(\SplSubject $splSubject): void
    { 
        $this->txt = $this->type.' type received '.$splSubject->getNotice().PHP_EOL;
    }
};

$adminEmail = new EmailObserver('admin');
$userEmail = new EmailObserver('user');

$error = new ErrorSubject();
$error->attach($adminEmail)->attach($userEmail);

$error->handle(38, 'Missing implementation');

return false !== strpos('n° 38', $userEmail->txt);
