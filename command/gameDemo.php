<?php

// http://gameprogrammingpatterns.com/command.html

function jump() { echo "jumps\n"; }
function fireGun() { echo "fires gun\n"; }
function swapWeapon() { echo "swaps weapon\n"; }
function duck() { echo "ducks\n"; }

const BUTTON_W = "w";
const BUTTON_A = "a";
const BUTTON_S = "s";
const BUTTON_D = "d";

class oldInputHandler {
    public function __construct() {
        system("stty -icanon");
    }

    public function isPressed($button) {
        $c = fread(STDIN, 1);
        return ($c == $button);
    }

    // what if we wanted the users to be able to map their own buttons?
    public function  handleInput() {
        if ($this->isPressed(BUTTON_W)) {
            jump();
        } elseif ($this->isPressed(BUTTON_A)) {
            fireGun();
        } elseif ($this->isPressed(BUTTON_S)) {
            swapWeapon();
        } elseif ($this->isPressed(BUTTON_D)) {
            duck();
        }
    }
}

interface Command {
    public function execute();
}

class JumpCommand implements Command {
    public function execute () { jump(); }
}
class FireGunCommand implements Command {
    public function execute () { fireGun(); }
}
class SwapWeaponCommand implements Command {
    public function execute () { swapWeapon(); }
}
class DuckCommand implements Command {
    public function execute () { duck(); }
}

class InputHandler {
    private $buttonW;
    private $buttonA;
    private $buttonS;
    private $buttonD;
    private $button_input;

    public function __construct() {
        $this->buttonW = new JumpCommand();
        $this->buttonA = new FireGunCommand();
        $this->buttonS = new SwapWeaponCommand();
        $this->buttonD = new DuckCommand();
        system("stty -icanon");
    }

    public function isPressed($button) {
        return ($this->button_input == $button);
    }

    // what if we wanted the users to be able to map their own buttons?
    public function  handleInput() {
        $this->button_input = fread(STDIN, 1);
        if ($this->isPressed(BUTTON_W)) {
            $this->buttonW->execute();
        } elseif ($this->isPressed(BUTTON_A)) {
            $this->buttonA->execute();
        } elseif ($this->isPressed(BUTTON_S)) {
            $this->buttonS->execute();
        } elseif ($this->isPressed(BUTTON_D)) {
            $this->buttonD->execute();
        }
    }
}


class App {
    public static function main() {
        $ih = new InputHandler();
        $ih->handleInput();
    }
}

App::main();

