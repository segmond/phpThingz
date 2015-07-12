<?php

/** Car has too many options, combation of each option would lead to a huge list of constructors.
    So we will create a builder class CarBuilder, we will send it each car option set by step
    and then construct the final car with the right options.
*/

class Car {
    private $seats;
    private $carType;
    private $radio;
    private $gps;

    public function __construct(CarBuilder $build) {
        $this->seats = $build->getSeats();
        $this->carType = $build->getCarType();
        $this->radio = $build->getRadio();
        $this->gps = $build->getGPS();
    }

    public function seat($x) {  
        if ($x > $this->seats) {
            echo "Sorry cannot seat $x people\n";
        } else {
            echo "Seating $x\ people\n";
        }
    }

    public function goSports() {
        if ($this->carType == 'sports') {
            echo "Sports go vrooooom\n";
        } else {
            echo "You can't drive this like a sports car\n";
        }
    }

    public function goSunshine() {
        if ($this->carType == 'cabriolet') {
            echo "Get some sunshine\n";
        } else {
            echo "Not a drop top\n";
        }
    }

    public function loadUpKids() {
        if ($this->carType == 'minivan') {
            echo "Soccer mom mode\n";
        } else {
            echo "Sorry, not a minivan, gotta take the bus with the kids\n";
        }
    }

    public function playIPad() {
        if ($this->radio == 'mp3') {
            echo "Rock on\n";
        } else {
            echo "Catch up and get an MP3 player\n";
        }
    }

    public function setGPS() {
        if ($this->gps == null) {
            echo "You are going to be lost\n";
        } else {
            echo "Got GPS, let's find Waldo\n";
        }
    }

}

class CarBuilder {
    private $seats = 4;
    private $carType = 'sedan';
    private $radio = 'am/fm';
    private $gps = null;

    public function getResult() {
        return new Car($this);
    }
    public function setSeats($num) {
        $this->seats = $num;
        return $this;
    }

    public function getSeats() {
        return $this->seats;
    }

    public function setSportsCar() {
        $this->carType = 'sports';
        return $this;
    }

    public function setCabriolet() {
        $this->carType = 'cabriolet';
        return $this;
    }
    public function setMinivan () {
        $this->carType = 'miniban';
        return $this;
    }

    public function getCarType() {
        return $this->carType;
    }

    public function setCDPlayer (){
        $this->radio = 'cd';
        return $this;
    }
    public function setMP3Player () {
        $this->radio = 'mp3';
        return $this;
    }
    public function getRadio() {
        return $this->radio;
    }
    public function setGPS () {
        $this->gps = 'gps';
        return $this;
    }
    public function getGPS() {
        return $this->gps;
    }
}

$carbuilder = new CarBuilder();
$carbuilder->setSeats(2);
$carbuilder->setSportsCar();
$carbuilder->setCDPlayer();
$carbuilder->setGPS();

$car = $carbuilder->getResult();

$car->seat(10);
$car->goSports();
$car->goSunshine();
$car->loadupKids();
$car->playIpad();
$car->setGPS();
