<?php

abstract class Cartriage {
    protected $name = 'no name';
    abstract function getType();

    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }
}


class GameBoyCartriage extends Cartriage {
    protected $type = 'gameboy';
    public function getType() {
        return $this->type;
    }
        
}

class NESCartriage extends Cartriage {
    protected $type = 'nes';
    public function getType() {
        return $this->type;
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


interface ITarget {
    function requester();
}

// build a class adapter
class NESToGameboyCartAdapter extends GameboyCartriage implements ITarget {
    private $cart;
    protected $name;

    public function __construct(NESCartriage $nesgame) {
        $this->cart = $nesgame;
        $this->requester();
    }

    public function requester() {
        $this->type = 'gameboy';
        $this->name = $this->cart->getName();
    }
}

// use the adapter
echo "\n";
$adapter = new NEStoGameboyCartAdapter($punchout);
$gb->insertCart($adapter);
$gb->play();
