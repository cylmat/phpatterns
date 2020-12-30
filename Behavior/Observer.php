<?php
// Your code here!
//register_shutdown_function('shutdownhandler');

function shutdownHandler() 
{
    //echo 'error';
}

$error = new class() implements SplSubject
{
    private $obs = [];
    private $notice;
    function attach(SplObserver $SplObserver) { $this->obs[] = $SplObserver;  }
    function detach(SplObserver $SplObserver) {}
    function notify() { foreach($this->obs as $obs){$obs->update($this);} }
    
    function handler(int $errno, string $errstr, string $errfile, int $errline) { 
        $this->notice = "Ceci EST l'erreur N0 $errstr";
        $this->notify();
    }
    function getNotice() {return $this->notice;}
}; 

trait StringFormatter { 
    function format(string $string):string { return strtolower($string); }
}

$HtmlFormatter = function (string $string):string { return strtoupper($string); }; 
//var_dump($HtmlFormatter);

$mail = new class($HtmlFormatter) implements SplObserver
{
    private $formatter; use StringFormatter;
    public $f;
    public function __construct($format) { $this->formatter = $format; }
    //use StringFormatter, HtmlFormatter { StringFormatter::format insteadof HtmlFormatter; StringFormatter::format as stringFormat; HtmlFormatter::format as htmlFormat; }
    function update(SplSubject $SplSubject) { 
        $f = $this->formatter; 
        
        if('string' == $this->f)
            echo $f($SplSubject->getNotice());  //echo $this->format( $SplSubject->getNotice() ); }  
        else
            echo $this->format($SplSubject->getNotice());
    }
};

$mail->f = 'tring';
$error->attach($mail);
set_error_handler([$error, 'handler'], E_ALL);

5/0;

