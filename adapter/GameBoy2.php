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
    public function getType() { return 'gameboy'; }

    public function getPinsize() { return 16; }
        
}

class NESCartriage extends Cartriage {
    public function getType() { return 'nes'; }

    public function getPinsize() { return 32; }
        
}

class GameBoy {
    private $cart;
    public function insertCart(GameBoyCartriage $c) {
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

    public function getPinSize() {
        return $this->cart->getPinsize();
    }
}

$mario = new GameBoyCartriage('Mario');
$punchout = new NESCartriage('Punchout');

$gb = new GameBoy();
$gb->insertCart($mario);
echo $mario->getPinSize() . "\n";
$gb->play();

echo "\n";
// we can't play NES punchout on gameboy
//$gb->insertCart($punchout);
//$gb->play();

// build an adapter
class NESToGameboyCartAdapter extends GameBoyCartriage {
    private $cart;
    public function insertCart(NESCartriage $cart) {
        $this->cart = $cart;
    }
        
    public function getName() {
        return $this->cart->getName();
    }

}

// use the adapter
echo "\n";
$adapter = new NEStoGameboyCartAdapter('adapter');
$adapter->insertCart($punchout);
$gb->insertCart($adapter);
echo $punchout->getPinSize() . "\n";
echo $adapter->getPinSize() . "\n";
$gb->play();
