<?php
/*
http://www.informatix.fr/articles/php/le-lazy-load-en-php-143
CLOSURE
*/
class Client
{
        protected $commandes = null;
        protected $prenom = null;

        public function __construct()
        {
                $this->prenom = 'Nicolas';

                /* L'attribut commandes utilise le lazy load car son initialisation est une operation lourde */
                $this->commandes = function ()
                {
                        $model = new ClientModel();
                        return $model->getToutesLesCommandes();
                };
        }

        public function __get($key)
        {
                if (is_callable($this->$key))
                {
                        $this->$key = call_user_func($this->$key);
                }

                return $this->$key;
        }
}

/*
With BUILD
*/
class Client
{
        protected $commandes = null;
        protected $adresses = null;

        public function buildCommandes()
        {
                /* Operation tres couteuse */
                echo "Et 5 tres longues secondes plus tard...";
                sleep(5);
                $this->commandes = array(
                        'commande1' => 123456,
                        'commande2' => 456789
                );
        }

        public function __get($key)
        {
                if (is_null($this->$key))
                {
                        $method = 'build' . ucfirst($key);
                        $this->$method();
                }

                return $this->$key;
        }
}

/*
2. https://verraes.net/2011/05/lazy-loading-with-closures/
*/
class CustomerRepository
{
    public function find($id)
    {
        $db = $this->db;
        $customerdata = $db->query(/* select customer ...*/);
        $customer = new Customer($customerdata);

        $ordersReference = function($customer) use($id, $db) {
            $ordersdata = $db->query(/* select orders ... */);
            $orders = array();
            foreach($ordersdata as $orderdata) {
                $orders[] = new Order($orderdata);
            }
            return $orders;
        };
        $customer->setOrderReference($ordersReference);
        return $customer;
    }
}