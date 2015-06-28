<?php

abstract class Cartriage {
    private $name = 'no name';
    abstract function getType();

    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }
}


class GameBoyCartriage extends Cartriage {
    public function getType() {
        return 'gameboy';
    }
        
}

class NESCartriage extends Cartriage {
    public function getType() {
        return 'nes';
    }
        
}

class GameBoy {
    private $cart;
    public function insertCart(Cartriage $c) {
        if ($c->getType() != 'gameboy') {
            echo ("incompatible cartriage type\n");
            $this->cart = null;
            return;
        }
        $this->cart = $c;
    }

    public function play() {
        if ($this->cart != null) {
            echo "Playing " . $this->cart->getName() . "\n";
        }
    }
}

$mario = new GameBoyCartriage('Mario');
$punchout = new NESCartriage('Punchout');

$gb = new GameBoy();
$gb->insertCart($mario);
$gb->play();

// attempt to play NES punchout on gameboy
echo "\n";
$gb->insertCart($punchout);
$gb->play();

// build an adapter
class NESToGameboyCartAdapter extends Cartriage {
    private $cart;
    public function insertCart(NESCartriage $cart) {
        $this->cart = $cart;
    }
        
    public function getName() {
        return $this->cart->getName();
    }

    public function getType() {
        return 'gameboy';
    }
}

// use the adapter
echo "\n";
$adapter = new NEStoGameboyCartAdapter('adapter');
$adapter->insertCart($punchout);
$gb->insertCart($adapter);
$gb->play();
