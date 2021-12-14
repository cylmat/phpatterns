<?php

namespace Phpatterns\Creational;

interface IColor { public function __toString(); }
interface IPolygon { public function getColor(): IColor; public function getType(): string; }

class RedColor implements IColor { function __toString() { return 'red'; } }
class GreenColor implements IColor { function __toString() { return 'green'; } }

class Polygon implements IPolygon // object to be created
{
    protected $color, $type;
    public function __construct(IColor $color) { $this->color = $color; }
    public function getColor(): IColor { return $this->color; }
    public function getType(): string { return $this->type; }
}

class Triangle extends Polygon { protected $type = 'triangle'; }
class Square extends Polygon { protected $type = 'square'; }

abstract class PolygonFactory // Factory pattern
{
    public function create(IColor $color) {
        return $this->createPrototype($color);
    }

    abstract protected function createPrototype(IColor $color): IPolygon;
}

class TriangleFactory extends PolygonFactory { 
    protected function createPrototype(IColor $color): IPolygon { return new Triangle($color); } 
}
class SquareFactory extends PolygonFactory {
    protected function createPrototype(IColor $color): IPolygon { return new Square($color); }
}

/**
 * Abstract factory
 */
interface IPolygonAbstractFactory { 
    public function createTriangle(); 
    public function createSquare();
}

class RedAbstractFactory implements IPolygonAbstractFactory // AbstractFactory pattern
{
    public function createTriangle(): IPolygon {
        return (new TriangleFactory)->create(new RedColor);
    }
    
    public function createSquare(): IPolygon {
        return (new SquareFactory)->create(new RedColor);
    }
}

$redTriangle = (new RedAbstractFactory())->createTriangle();
return 'red triangle' === $redTriangle->getColor().' '.$redTriangle->getType();

