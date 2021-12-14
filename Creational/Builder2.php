<?php

namespace Phpatterns\Creational;

interface BuilderInterface
{
    public function addKeyboard(): void;
    public function addMouse(): void;
    public function addStorage(string $type): void;
}

interface DirectorInterface
{
    public function build(BuilderInterface $builder): Computer;
}

class Computer
{
    protected $keyboard, $mouse, $storages = [];

    public function setKeyboard(bool $type = true) { $this->keyboard = $type ? 'azerty' : 'qwerty'; }
    
    public function setMouse() { $this->mouse = 'classic'; }
    
    public function addStorage(string $type = 'disk') { $this->storages[] = $type; } //usb, sd
    
    public function __toString() { return sprintf("%s, %s and -%s- computer", $this->keyboard, $this->mouse, join(',', $this->storages)); }
}

class ClassicBuilder implements BuilderInterface
{
    /** @var Computer */
    public $computer;

    public function __construct(Computer $computer) { $this->computer = $computer; }
    
    public function addKeyboard(): void { $this->computer->setKeyboard(true); }
    
    public function addMouse(): void { $this->computer->setMouse(); }
    
    public function addStorage(string $type): void { $this->computer->addStorage($type); }
}

class MultipleStorageDirector implements DirectorInterface
{
    public function __construct() { return $this; }
    
    public function build(BuilderInterface $builder): Computer
    {
        $builder->addKeyboard();
        $builder->addMouse();
        $builder->addStorage('disk');
        $builder->addStorage('disk');
        $builder->addStorage('usb');

        return $builder->computer;
    }
}

$computer = (string)(new MultipleStorageDirector())->build(new ClassicBuilder(new Computer()));
return false !== strpos($computer, 'disk');
