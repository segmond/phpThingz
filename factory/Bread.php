<?php

interface Bread {
    public function getType();
}

class BananaBread implements Bread {
    public function getType() {
        return 'Banana Bread';
    }
}

interface BreadFactory {
    public function makeBread();
}

class BananaBreadFactory implements BreadFactory {
    public function makeBread() {
        return new BananaBread();
    }
}

$factory = new BananaBreadFactory();
$bread = $factory->makeBread();
echo $bread->getType();
