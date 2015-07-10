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
class Fan {
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

LightDemo::main($argv[1]);
RadioDemo::main($argv[1]);
