<?php

/** the command interface */
interface Command {
    function execute();
}

/** the invoker class */
class ASwitch {
    private $history;

    public function __construct() {
        $history = array();
    }

    public function storeAndExecute(Command $cmd) {
        $this->history[] = $cmd; // optional
        $cmd->execute();
    }

    public function execute(Command $cmd) {
        $cmd->execute();
    }
}

abstract class Electronics {
    abstract public function turnOn();
    abstract public function turnOff();
}

/** The receiver class */
class Light extends Electronics {
    public function turnOn() {
        echo "The light is on\n";
    }

    public function turnOff() {
        echo "The light is off\n";
    }
}

/** The receiver class */
class Radio extends Electronics {
    public function turnOn() {
        echo "The radio is on\n";
    }

    public function turnOff() {
        echo "The radio is off\n";
    }
}

/** Another receiver class */
class Fan extends Electronics{
    private $states;
    private $current_state;

    public function __construct() {
        $this->states = array('off', 'low', 'medium', 'high');
        $this->current_state = 0;
    }

    public function nextTurn() {
        $next = ($this->current_state++) % count($this->states);
        $this->{$this->states[$next]}();
    }

    public function prevTurn() {
        $prev = ($this->current_state--) % count($this->states);
        $this->{$this->states[$prev]}();
    }
        
    public function low() {
        echo "The fan is blowing low\n";
    }

    public function medium() {
        echo "The fan is blowing medium\n";
    }
    public function high() {
        echo "The fan is blowing high\n";
    }
    public function off() {
        echo "The fan is off\n";
    }

    public function turnOn() {
        $this->current_state=1;
        $this->low();
    }

    public function turnOff() {
        $this->current_state=0;
        $this->off();
    }
}


/** The command for turning on the light */
class FlipUpCommand implements Command {
    private $device;

    public function __construct(Electronics $device) {
        $this->device = $device;
    }

    public function execute() {
        $this->device->turnOn();
    }
}

/** The command for turning off the light */
class FlipDownCommand implements Command {
    private $device;

    public function __construct(Electronics $device) {
        $this->device = $device;
    }

    public function execute() {
        $this->device->turnOff();
    }
}

class LightDemo {
    public static function main($cmd) {
        $lamp = new Light();
        $switchUp = new FlipUpCommand($lamp);
        $switchDown = new FlipDownCommand($lamp);

        $mySwitch = new ASwitch();
        switch(strtoupper($cmd)) {
            case "ON":
                $mySwitch->storeAndExecute($switchUp);
                break;
            case "OFF":
                $mySwitch->storeAndExecute($switchDown);
                break;
            default:
                die("Argument must be 'ON' or 'OFF'\n");
        }
                
    }

}

class RadioDemo {
    public static function main($cmd) {
        $radio = new Radio(); // receiver of the command
        $switchUp = new FlipUpCommand($radio); // command
        $switchDown = new FlipDownCommand($radio);

        $mySwitch = new ASwitch(); // invoker
        switch(strtoupper($cmd)) {
            case "ON":
                $mySwitch->execute($switchDown); // execute command
                break;
            case "OFF":
                $mySwitch->execute($switchUp);
                break;
            default:
                die("Argument must be 'ON' or 'OFF'\n");
        }
                
    }

}

//LightDemo::main($argv[1]);
//RadioDemo::main($argv[1]);

/** rotating command for a rotary switch */
class RotateRightCommand implements Command {
    private $device;

    public function __construct(Electronics $device) {
        $this->device = $device;
    }

    public function execute() {
        $this->device->nextTurn();
    }
}

/** rotating command for a rotary switch */
class RotateLeftCommand implements Command {
    private $device;

    public function __construct(Electronics $device) {
        $this->device = $device;
    }

    public function execute() {
        $this->device->prevTurn();
    }
}


class FanDemo {
    public static function main($argv) {
        array_shift($argv);
        $fan = new Fan(); // receiver of the command
        $switchRight = new RotateRightCommand($fan); // command
        $switchLeft = new RotateLeftCommand($fan);

        $mySwitch = new ASwitch(); // invoker
        foreach ($argv as $cmd) {
            switch(strtoupper($cmd)) {
                case "R":
                    $mySwitch->execute($switchRight); // execute command
                    break;
                case "L":
                    $mySwitch->execute($switchLeft);
                    break;
                default:
                    die("Argument must be 'R' or 'L'\n");
            }
        }
                
    }

}

FanDemo::main($argv);
