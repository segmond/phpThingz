<?php


interface IVisible {
    function see();
}

interface IMovement {
    function move();
}

class Visible implements IVisible {
    public function see() { 
        echo "I'm visible\n";
    }
}
class Invisible implements IVisible {
    public function see() {
        echo "Can't be seen\n";
    }
}
class Moveable implements IMovement {
    public function move() {
        echo "moving along\n";
    }
}
class Immoveable implements IMovement {
    public function move() {
        echo "staying put\n";
    }
}
class GameObject {
    private $objname;

    public function __construct($name, IMovement $m, IVisible $v) {
        $this->objname = $name;
        $this->m = $m;
        $this->v = $v;
    }

    public function move() {
        echo $this->objname . ": ";
        $this->m->move();
    }

    public function see() {
        echo $this->objname . ": ";
        $this->v->see();
    }
}

class Ghost extends GameObject {
    public function __construct($name) {
        parent::__construct($name, new Moveable(), new Invisible());
    }
}

class Mountain extends GameObject {
    public function __construct($name) {
        parent::__construct($name, new Immoveable(), new Visible());
    }
}

$g = new Ghost("ghost");
$m = new Mountain("mountain");

$g->move();
$m->move();

$g->see();
$m->see();
