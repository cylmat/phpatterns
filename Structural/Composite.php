<?php

/*
 * Composite: describes a group of objects that are treated the same way as a single instance of the same type of object,
 * "compose" objects into tree structures to represent part-whole hierarchies
 */

interface PayableInterface
{
    public function getAmount(): int;
}

class ClientWallet implements PayableInterface
{
    private $values;
    
    public function add(PayableInterface $value)
    {
        if (null === $this->values) {
            $this->values = [];
        }
        $this->values[] = $value;
    }
    
    public function getAmount(): int
    {
        $sum = 0;
        foreach ($this->values as $value) {
            $sum += $value->getAmount();
        } 
        return $sum;
    }
}

class ClientValue implements PayableInterface
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getAmount(): int
    {
        return $this->value;
    }
}

$wallet = new ClientWallet();
$wallet->add($value = new ClientValue(5));
$wallet->add(new ClientValue(15));

return '5&20' === $value->getAmount() . '&' . $wallet->getAmount();
