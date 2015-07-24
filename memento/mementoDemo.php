<?php

class Originator {
    private $state;

    public function set($state) {
        echo "Originator: Setting state to $state\n";
        $this->state = $state;
    }

    public function saveToMemento() {
        echo "Originator: Saving to Memento.\n";
        return new Memento($this->state);
    }

    public function restoreFromMemento(Memento $memento) {
        $this->state = $memento->getSavedState();
        echo "Originator: State after restoring from Memento: $this->state\n";
    }

}

class Memento {
    private $state;

    public function __construct($stateToSave) {
        $this->state = $stateToSave;
    }

    public function getSavedState() {
        return $this->state;
    }
}

class Caretaker {
    public static function main() {
        $savedStates = array();

        $o = new Originator();
        $o->set("State1");
        $o->set("State2");
        $savedStates[] = $o->saveToMemento();
        $o->set("State3");
        $savedStates[] = $o->saveToMemento();
        $o->set("State4");

        $o->restoreFromMemento($savedStates[0]);
    }
}

Caretaker::main();
