<?php
// Your code here!

/**
 * computer:portable,desk,station
 *      locked:free
 *      keyboard:azerty,qwerty
 *      mouse:classic,adaptatic
 *      disk,usb,sd
 */

class Computer
{
    protected $keyboard, $mouse, $storages=[];
    function setKeyboard(bool $type=true)
    {
        $this->keyboard = $type ? 'azerty' : 'qwerty';
    }
    
    function setMouse(bool $type=true)
    {
        $this->mouse = $type ? 'classic' : 'adaptatic';
    }
    
    function addStorage(string $type='disk')
    {
        $this->storages[] = $type; //usb, sd
    }
    
    function __toString() { return sprintf("My %s and %s -%s- computer", $this->keyboard, $this->mouse, join(',',$this->storages)); }
}

interface IBuilder
{
    function addKeyboard(): void;
    function addMouse(): void;
    function addStorage($type): void;
}

class ClassicBuilder implements IBuilder
{
    public $computer;
    public function __construct(Computer $computer)
    {
        $this->computer = $computer;
    }
    
    function addKeyboard(): void
    {
        $this->computer->setKeyboard(true);
    }
    
    function addMouse(): void
    {
        $this->computer->setMouse(true);
    }
    
    function addStorage($type): void
    {
        $this->computer->addStorage($type);
    }
}

interface IDirector
{
    function build(IBuilder $builder): Computer;
}

class MultipleStorageDirector implements IDirector
{
    function build(IBuilder $builder): Computer
    {
        $builder->addKeyboard();
        $builder->addMouse();
        $builder->addStorage('disk');
        $builder->addStorage('disk');
        $builder->addStorage('usb');
        return $builder->computer;
    }
}

echo (new MultipleStorageDirector)->build(new ClassicBuilder(new Computer));