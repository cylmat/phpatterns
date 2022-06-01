<?php

/*
 * Bridge: decouple an abstraction from its implementation so that the two can vary independently
 */

interface MyFeatureAbstract { public function useClientFeature(): string; }
interface ExtImplementation { public function vendorReturnSomeData(): string; }

class AbstractionClass implements MyFeatureAbstract
{
    private $implement;
    
    public function __construct(ExtImplementation $implement) {
        $this->implement = $implement;
    }
    
    public function useClientFeature(): string {
        return $this->implement->vendorReturnSomeData();
    }
}

class VendorVersion1 implements ExtImplementation
{
    public function vendorReturnSomeData(): string {
        return 'old school -data-';
    }
}

class VendorVersion3 implements ExtImplementation
{
    public function vendorReturnSomeData(): string {
        return 'awesome feature';
    }
}


$myClientSide = new AbstractionClass(new VendorVersion1());
$myClientSide3 = new AbstractionClass(new VendorVersion3());

return "old school -data-awesome feature" ===  $myClientSide->useClientFeature() .  $myClientSide3->useClientFeature();
