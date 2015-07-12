<?php

abstract class Game {
    protected $playersCount;
    abstract public function initializeGame();
    abstract public function makePlay($playerNum);
    abstract public function endOfGame();
    abstract public function printWinner();

    /** A template method */
    public final function playOneGame($playersCount) {
        $this->playersCount = $playersCount();
        $this->initializeGame();
        $j = 0;
        while (!$this->endOfGame()) {
            $this->makePlay($j);
            $j = $j++ % $this->playersCount;
        }
        $this->printWinner();
    }
}

class Monopoly extends Game {
    public function initializeGame() {
    }

    public function makePlay($playerNum) {
    }

    public function endOfGame() {
    }

    public function printWinner() {
    }
}

class Chess extends Game {
    public function initializeGame() {
    }

    public function makePlay($playerNum) {
    }

    public function endOfGame() {
    }

    public function printWinner() {
    }
}
