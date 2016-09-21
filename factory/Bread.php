<?php

interface Bread {
    public function getType();
}

class BananaBread implements Bread {
    public function getType() {
        return 'Banana Bread';
    }
}

class PitaBread implements Bread {
    public function getType() {
        return 'Pita Bread';
    }
}

interface IBreadFactory {
    public function makeBread($type);
}

class BreadFactory implements IBreadFactory {

	public function makeBread($bread_type) {
		switch (strtoupper($bread_type)) {
			case 'BANANA':
				return $this->makeBananaBread();
			case 'PITA':
				return $this->makePitaBread();
			default:
				return null;
		}

	}
    public function makeBananaBread() {
        return new BananaBread();
    }
    public function makePitaBread() {
        return new PitaBread();
    }
}

$factory = new BreadFactory();
$bread = $factory->makeBread('pita');
echo $bread->getType();
