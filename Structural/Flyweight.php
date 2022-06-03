<?php

/*
 * Flyweight: object that minimizes memory usage by sharing some of its data with other similar objects
 *  Intrinsic data: stored in the flyweight object, independent of the context so sharable
 *  Extrinsic data: depends on the flyweight’s context (position, name, ...)
 *
 * This pattern can use a "Pool factory" pattern to create objects
 *
 * 2 versions: 
 * - One can use few "heavy" objects with intrinsic state and pass ("extrinsic") data in method arguments
 * - One can use multiple "light" objects with extrinsic data and pass ("shared") data in method or constructor
 */

/*
 * Few heavy objects version
 */

interface Pixel
{
    function display(int $coordX): string;
}

class HeavyPixel implements Pixel
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
    
    public function display(int $coordX): string {
        return $this->intrinsic['color'].$coordX;
    }
}

// Only one heavy class
$heavyRed = new HeavyPixel('red');

$display = '';
for ($coordX=0; $coordX<3; $coordX++) {
    $display .= $heavyRed->display($coordX);
}

// display light memory values
return 'red0red1red2' === $display;
