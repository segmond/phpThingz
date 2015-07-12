<?php

abstract class Controller {
    protected $playersCount;
    abstract public function indexAction($params);

    /** A template method */
    public final function render($x) {
        echo $this->indexAction($x) . "\n";
    }
}

class HelloController extends Controller {
    public function indexAction($name) {
        return "<html><body>Hello $name</body></html>";
    }
}

class ByeController extends Controller {
    public function indexAction($name) {
        return "<html><body>Goodbye $name</body></html>";
    }
}

$hello = new HelloController();
$hello->render('world');

$bye = new ByeController();
$bye->render('Yall');
