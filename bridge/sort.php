<?php

interface Sortable {
    public function sort();
}

abstract class Shape {
    abstract function area();

    public function compare(Shape $b) {
        return $this->area() > $b->area();
    }
}

class Triangle extends Shape {
    private $base;
    private $height;

    public function __construct($base, $height) {
        $this->base = $base;
        $this->height = $height;
    }

    public function area() {
        return ($this->base / 2 ) * $this->height;
    }
}

class Square extends Shape {
    private $length;

    public function __construct($length) {
        $this->length = $length;
    }

    public function area() {
        return $this->length * $this->length;
    }
}

/** we are going to separate the implementation of sort away from this */
class Collections implements Sortable {
    private $list;
    private $sortAPI;

    public function __construct($sortAPI) {
        $this->list = array();
        $this->sortAPI = $sortAPI;
    }

    public function add(Shape $shape) {
        $this->list[] = $shape;
    }

    public function sort() {
        $this->list = $this->sortAPI->sort($this->list);
    }

    public function __toString() {
        $string = "";

        foreach($this->list as $shape) {
            if ($shape instanceof Square) {
                $string .= "S";
            } elseif ($shape instanceof Triangle) {
                $string .= "T";
            }
            $string .= $shape->area() . " ";
        }
    
        return $string;
    }
        
}

interface SortAPI {
    public function sort($list);
}

class QuickSort implements SortAPI {
    public function sort($list) {
        if (count($list) < 2) {
            return $list;
        }
        $left = $right = array();
        reset($list);
        $pivot_key  = key($list);
        $pivot  = array_shift($list);
        foreach ($list as $k => $v) {
            if ($pivot->compare($v)) {
                $left[$k] = $v;
            } else {
                $right[$k] = $v;
            }
        }
        return array_merge($this->sort($left), array($pivot_key => $pivot), $this->sort($right));
    }
}

class BubbleSort implements SortAPI {
    function sort($list) {
        $n = count($list) - 1;
        do {
            $swapped = false;
            for ($i = 0; $i < $n; ++$i) {
                if ($list[$i]->compare($list[$i + 1])) {
                    $t = $list[$i];
                    $list[$i] = $list[$i + 1];
                    $list[$i + 1] = $t;
                    $swapped = true;
                }
            }
        } while ($swapped);
        return $list;
    }
}

class App {
    public function getRandShape() {
        if (rand(1, 10) > 5) {
            echo "getting triangle\n";
            return new Triangle(rand(1,20), rand(1,20));
        } else {
            echo "getting square\n";
            return new Square(rand(1, 20));
        }
    }


    public function main() {
        $c = new Collections(new QuickSort());
        for ($i = 0; $i < 20; $i++) {
            $shape = $this->getRandShape();
            echo "\t area is " . $shape->area() . "\n";
            $c->add($shape);
        }
        echo $c . "\n";
        $c->sort();
        echo $c . "\n";
    }

}

$app = new App();
$app->main();
