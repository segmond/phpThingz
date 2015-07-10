<?php

class FlyweightInsect {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function crawl() {
        echo $this->name . " is crawling\n";
    }
}

class InsectFactory {
    private $insects;

    public function __construct() {
        $this->insects = array();
    }

    public function lookup($name) {
        if (!isset($this->insects[$name])) {
            $this->insects[$name] = new FlyweightInsect($name);
        }
        return $this->insects[$name];
    }

    public function totalInsectsType() {
        return count($this->insects);
    }
}

class bugCreator {
    private $num;
    private $insectType;

    public function __construct($num, FlyweightInsect $type) {
        $this->num = $num;
        $this->insectType = $type;
    }

    public function show() {
        echo "Bug number $this->num is of type " . $this->insectType->getName() . "\n";
    }

    public function crawl() {
        $this->insectType->crawl();
    }
}

class Bush {
    private $insects;
    private $insectFactory;

    public function __construct() {
        $this->insects = array();
        $this->insectFactory = new InsectFactory();
    }

    public function placeInsect($type, $id) {
        $insect = $this->insectFactory->lookup($type);
        $bug = new bugCreator($id, $insect);
        $this->insects[] = $bug;
    }

    public function listInsects() {
        foreach ($this->insects as $bug) {
            $bug->show();
            $bug->crawl();
        }
    }

    public function report() {
        echo "Total insect types made: " . $this->insectFactory->totalInsectsType() . "\n";
    }

    public static function main() {
        $bush = new Bush();

        $bugTypes = array('Bee', 'Butterfly', 'Moth', 'Wasp', 'Roach', 'Housefly');

        for ($i = 1; $i < 10; $i++) {
            $rand_key = array_rand($bugTypes, 1);
            $bush->placeInsect($bugTypes[$rand_key], $i);
        }

        $bush->listInsects();
        $bush->report();
    }
}

Bush::main();
