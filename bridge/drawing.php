<?php

interface DrawingAPI {
    function drawCircle($x, $y, $radius);
}

class DrawingAPI1 implements DrawingAPI {
    public function drawCircle($x, $y, $radius) {
        echo "API 1 drawing circle at $x:$y radius $radius.\n";
    }
}

class DrawingAPI2 implements DrawingAPI {
    public function drawCircle($x, $y, $radius) {
        echo "API 2 drawing circle at $x:$y radius $radius.\n";
    }
}
class OpenGLAPI implements DrawingAPI {
    public function drawCircle($x, $y, $radius) {
        echo "Open GL API drawing circle at $x:$y radius $radius.\n";
    }
    public function drawSquare($x, $y, $side) {
        echo "Open GL API drawing square at $x:$y side $side.\n";
    }
}

/** Abstraction */
abstract class Shape {
    protected $drawingAPI;

    public abstract function draw();
    public abstract function resizeByPercentage($pct);

    protected function __construct(DrawingAPI $drawingAPI) {
        $this->drawingAPI = $drawingAPI;
    }
}

class CircleShape extends Shape {
    private $x;
    private $y;
    private $radius;

    public function __construct($x, $y, $radius, DrawingAPI $drawingAPI) {
        parent::__construct($drawingAPI);
        $this->x = $x;
        $this->y = $y;
        $this->radius = $radius;
    }

    public function draw() {
        $this->drawingAPI->drawCircle($this->x, $this->y, $this->radius);
    }

    public function resizeByPercentage($pct) {
        $this->radius *= $pct;
    }
}

class SquareShape extends Shape {
    private $x;
    private $y;
    private $radius;

    public function __construct($x, $y, $side,  DrawingAPI $drawingAPI) {
        parent::__construct($drawingAPI);
        $this->x = $x;
        $this->y = $y;
        $this->side = $side;
    }

    public function draw() {
        $this->drawingAPI->drawSquare($this->x, $this->y, $this->side);
    }

    public function resizeByPercentage($pct) {
        $this->side *= $pct;
    }
}

class Tester {
    public static function main() {
        $open_gl_api = new OpenGLAPI();
        $shapes = array(
            new CircleShape(1,3,7, $open_gl_api),
            new CircleShape(5,7,11, $open_gl_api),
            new SquareShape(20,20,5, $open_gl_api),
        );

        foreach ($shapes as $shape) {
            $shape->resizeByPercentage(2.5);
            $shape->draw();
        }
    }
}

Tester::main();

