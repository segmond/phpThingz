<?php

interface ICar {
    function driveCar(Driver $driver);
}

class Car implements ICar {
    public function driveCar(Driver $driver) {
        echo "Car has been driven by $driver->name\n";
    }
}


class Driver {
    public $name;
    public $age;

    public function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
    }
}

$driver = new Driver('ken', 15);
$noproxy_car = new Car();
$noproxy_car->driveCar($driver);


class ProxyCar implements ICar {
    private $car;
    
    public function __construct() {
        $this->car = new Car();
    }

    public function driveCar(Driver $driver) {
        if ($driver->age <= 16) {
            echo "Sorry, driver is too young to drive\n"; // Add protection
        } else {
            $this->car->driveCar($driver);
        }
    }
}


$noproxy_car = new ProxyCar();
$noproxy_car->driveCar($driver);
