<?php

/*
 * Multiple light objects version
 */

interface Pixel
{
    function display(): string;
}

class HeavyData
{
    private $intrinsic = [
        'heavy' => 'HEAVY DATA VALUES - 123456789.bmp',
        'type' => 'point',
        'color' => null
    ];
    
    public function __construct(string $color) {
        $this->intrinsic['color'] = $color;
    }
    
    public function getColor(): string {
        return $this->intrinsic['color'];
    }
}

class FlyweightPixel implements Pixel
{
    private $sharedState;
    private $coordX; //extrinsic "individual" data

    public function __construct(HeavyData $sharedState, int $coordX) {
        $this->sharedState = $sharedState;
        $this->coordX = $coordX;
    }
    
    function display(): string {
        return $this->sharedState->getColor().$this->coordX;
    }
}

// One heavy specific class, multiple flyweight objects
$heavyRed = new HeavyData('red');
$redPixels = [];

$display = '';
for ($coordX=0; $coordX<3; $coordX++) {
    $redPixels[] = $flyweight = new FlyweightPixel($heavyRed, $coordX);
    $display .= $flyweight->display();
}

// display light memory objects
return 'red0red1red2' === $display;
