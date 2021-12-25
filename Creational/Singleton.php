<?php

/*
 * SingletonInterface: private __construct, static getInstance
 */

namespace Phpetterns\Creational;

class Singleton
{
    private $params;
    private static $singleInstance = null;
    
    private function __construct(string $params)
    {
        $this->params = $params;
    }
    
    public static function getInstance(string $params): self
    {
        if (null === self::$singleInstance) {
            self::$singleInstance = new self($params);
        }
        return self::$singleInstance;
    }
    
    public function getParams(): string
    {
        return $this->params;
    }
}

class UsingSingle
{
    private $single;
    
    public function __construct(Singleton $single)
    {
        $this->single = $single;
    }
    
    public function getSingle(): Singleton
    {
        return $this->single;
    }
}

$globalConfig = 'config_parameters';
$single = Singleton::getInstance($globalConfig);

$using = new UsingSingle($single);
return 'config_parameters' === $using->getSingle()->getParams();
