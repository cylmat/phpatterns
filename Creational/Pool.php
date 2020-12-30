<?php declare(strict_types=1);

namespace Patterns;

$r = 5;


/**
 * WorkerPool
 */
class WorkerPool implements \Countable
{
    private $occupied=[];
    private $free=[];

    /**
     * Constructor method
     */
    public function __construct() 
    {

    }

    
    /*function blob(string $alpha): void
    {
        if( (strlen($alpha)<4 ))
            throw new \InvalidArgumentException('Expect $alpha to be > than 3 caracteres');
        try {
             
        } catch (\InvalidArgumentException $th) {
            echo $th.'bagua';
        }
        echo $alpha;
    }*/

    /**
     * 
     */
    public function get(): Worker
    {
        if(count($this->free)==0)
            $worker = new Worker();
        else
            $worker = array_pop($this->free);   

        $this->occupied[spl_object_hash($worker)] = $worker;
        return $worker;
    }

    public function dispose(Worker $worker)
    {
        $key = spl_object_hash($worker);

        if(isset($this->occupied[$key])) {
            unset($this->occupied[$key]);
            $this->free[$key] = $worker;
        }
    }

    public function count()
    {
        return count($this->free)+count($this->occupied);
    }

}//end class

class Worker
{
    private $created_at;
    public $id;

    public function __construct()
    {
        $this->id = uniqid();
        $this->created_at = date('m-s'); 
    }

    public function work()
    {
        return $this->id.' working..'."\n";
    }
}
