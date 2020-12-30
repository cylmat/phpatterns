<?php
// Your code here!
/*
    cheese:goat,mozza,french
    sauce:tomato,pepper,mayo
    
    pizza:cheese,pepperoni,veggie
    
    topAbstractFactory:sicil(mozza+tomato),gourmet(french+mayo)
    sicilpizza(3),gourmetpizza(3)
    
    surface:smooth, rough, or bump
    color:red,green,blue
    polynome:triangle,square,round
    
    DocumentCreator 
        createLetter
        createResume
    -> fancyDocumentCreator 
        fancyLetter  (createLetter)
        modernResume (createResume)
*/

interface IColor //red,green,blue
{
    public function getColor();
}

class RedColor implements IColor { function getColor() { return 'red'; } }
class OrangeColor implements IColor { function getColor() { return 'red+yellow'; } }
class GreenColor implements IColor { function getColor() { return 'green'; } }

interface ISurface //smooth, rough, or bump
{
    public function getSurface();
}

class SmoothSurface implements ISurface { function getSurface() { return 'smooth'; } }
class RoughSurface implements ISurface { function getSurface() { return 'rough'; } }

/**
 *  Polygon
 */
interface IPolygon //triangle,square,round
{
    public function getSurface();
    public function getColor();
    public function getType();
}

abstract class Polygon implements IPolygon
{
    protected $color, $surface, $type;
    public function __construct($color, $surface) { $this->color=$color; $this->surface=$surface; }
    public function getSurface() { return $this->color; }
    public function getColor() { return $this->surface; }
    public function getType() { return $this->type; }
    public function __toString() { return sprintf("A nice -%s- -%s- '%s'.\n",$this->color->getColor(), $this->surface->getSurface(), $this->type); }
    public function __clone() { echo ' cloning... '; }
}

class Triangle extends Polygon { protected $type='triangle'; }
class Square extends Polygon { protected $type='square'; }

/**
 * Factory
 */
abstract class PolygonFactory
{
    protected static $prototype=[];
    public function create(IColor $color, ISurface $surface)
    {
        if (!array_key_exists(static::class, static::$prototype)) {
            static::$prototype[static::class] = $this->createPrototype($color, $surface);
            return static::$prototype[static::class];
        }
        return (static::$prototype[static::class]);
    }
    abstract protected function createPrototype(IColor $color, ISurface $surface): IPolygon;
}

class TriangleFactory extends PolygonFactory { function createPrototype(IColor $color, ISurface $surface): IPolygon { return new Triangle($color, $surface); } }
class SquareFactory extends PolygonFactory { function createPrototype(IColor $color, ISurface $surface): IPolygon { return new Square($color, $surface); } }

interface PolygonAbstractFactory 
{
    public function createTriangle();
    public function createSquare();
}

class RedAbstractFactory implements PolygonAbstractFactory
{
    protected $surface;
    public function __construct(ISurface $surface) { $this->surface = $surface; }
    
    public function createTriangle(): IPolygon
    {
        return (new TriangleFactory)->create(new RedColor, $this->surface);
    }
    
    public function createSquare(): IPolygon
    {
        return (new SquareFactory)->create(new RedColor, $this->surface);
    }
}

$red = new RedAbstractFactory(new RoughSurface);
echo $red->createTriangle();
echo $red->createSquare();
echo $red->createSquare();
echo $red->createSquare();