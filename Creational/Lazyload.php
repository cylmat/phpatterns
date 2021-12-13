<?php

namespace Phpatterns\Creational;

// http://www.informatix.fr/articles/php/le-lazy-load-en-php-143
class LazyloadCommands
{
    public $data = [];
    protected $commandes = null;

    public function getCommands()
    {
        return function () { // defer loading
            return 'Waiting...Get all commands'.PHP_EOL;
        };
    }

    public function buildCommandes() // load only once
    {
        if (null === $this->commands) {
            $this->commandes = array(
                'commande1' => 123456,
                'commande2' => 456789
            );
        }
        return $this->commands();
    }
}

// 2. https://verraes.net/2011/05/lazy-loading-with-closures/
class LazyCustomerRepository
{
    private $db = null;

    public function __construct()
    { 
        $this->db = new class { 
            function queryCustomers() {
                return new class {
                    private $data;
                    function setOrder(callable $data) { $this->data = $data; }
                    function getOrder(): callable { return $this->data; }
                };
            }
            function queryOrders() { return ['order1', 'order2']; }
        }; 
    }

    public function find()
    {
        $customer = $this->db->queryCustomers();
        $ordersReference = function(string $customerId) {
            return $this->db->queryOrders();
        };

        $customer->setOrder($ordersReference);
        return $customer;
    }
}

$allCommands = (new LazyloadCommands())->getCommands();
// $allCommands();

$allCustomers = (new LazyCustomerRepository())->find();
$data = $allCustomers->getOrder();
$order1 = $data('customerid')[0];

return $order1 === 'order1';
