<?php

class NullObject {
    public function __set($name, $value) { }
    public function __get($name) { return null; }
    public function __isset($name) { return false; }
    public function __unset($name) { }
    public function __call($name, $arguments) { }

    public static function __callStatic($name, $arguments) { }
}


interface IAnimal {
    public function makeSound();
}

class Dog implements IAnimal {
    public function makeSound() {
        echo "woof\n";
    }
}

class NullAnimal extends NullObject implements IAnimal {
    public function makeSound() { }
}

$dog = new Dog();
$dog->makeSound();

$unknown = new NullAnimal();
$unknown->makeSound();
