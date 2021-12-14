<?php

namespace Phpatterns\Creational;

class Worker
{
    private $created_at;
    private $id;

    public function __construct()
    {
        $this->id = uniqid();
        $this->created_at = date('m-s'); 
    }

    public function work(): string
    {
        return $this->id." working...\n";
    }
}

class WorkerPool implements \Countable
{
    private $occupied = [];
    private $free = [];

    public function get(): Worker
    {
        if (0 === \count($this->free))
            $worker = new Worker();
        else
            $worker = \array_pop($this->free);   

        $this->occupied[\spl_object_hash($worker)] = $worker;
        return $worker;
    }

    public function dispose(Worker $worker)
    {
        $key = \spl_object_hash($worker);

        if (isset($this->occupied[$key])) {
            unset($this->occupied[$key]);
            $this->free[$key] = $worker;
        }
    }

    public function count()
    {
        return \count($this->free) + \count($this->occupied);
    }
}

$pool = new WorkerPool();
$pool->get();
$pool->get();
$worker = $pool->get();
$pool->dispose($worker);

return 3 === $pool->count();
