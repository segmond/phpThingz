<?php

interface TransportStrategy {
    function takeToAirport($person);
}

class ShuttleStrategy implements TransportStrategy {
    public function takeToAirport($person) {
        echo "taking $person to airport with a shuttle, time 10 seconds, price $50,000\n";
    }
}

class TaxiStrategy implements TransportStrategy {
    public function takeToAirport($person) {
        echo "Taxi taking $person to airport, time 30 minutes, price $50\n";
    }
}

class PersonalCarStrategy implements TransportStrategy {
    public function takeToAirport($person) {
        echo "$person Driving own car to airport, time 15 minutes, price $0\n";
    }
}

class CityBusStrategy implements TransportStrategy {
    public function takeToAirport($person) {
        echo "Bus taking $person to airport, time 1 hour, price $5\n";
    }
}

class Person {
    private $strategy;
    private $name;

    public function __construct($name, TransportStrategy $s) {
        $this->name = $name;
        $this->strategy = $s;
    }

    public function travel() {
        $this->strategy->takeToAirport($this->name);
    }

    public function setStrategy(TransportStrategy $s) {
        $this->strategy = $s;
    }
        
}

class Tester 
{
    public static function main() {
        $john = new Person('john', new CityBusStrategy());
        $john->travel();

        $john->setStrategy(new ShuttleStrategy());
        $john->travel();

    }
}

Tester::main();
