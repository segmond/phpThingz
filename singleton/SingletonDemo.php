<?php

// Lazy initialization
class SingletonDemo {
    private static $instance = null;
    private $registry = array();

    private function __construct() { }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new SingletonDemo();
        }
        return self::$instance;
    }

    public function setRegister($key, $val) {
        echo "setting $key\n";
        $this->registry[$key] = $val;
    }

    public function getRegister($key) {
        return $this->registry[$key];
    }
}


$s = SingletonDemo::getInstance();

$s->setRegister('MI', 'Michigan');
$s->setRegister('NY', 'New York');
$s->setRegister('OH', 'Ohio');

echo $s->getRegister('NY') . "\n";
echo $s->getRegister('OH') . "\n";
echo $s->getRegister('MI') . "\n";

unset($s);

$t = SingletonDemo::getInstance();
echo $t->getRegister('NY') . "\n";
echo $t->getRegister('OH') . "\n";
echo $t->getRegister('MI') . "\n";

$y = $t;
echo $y->getRegister('NY') . "\n";

// below will fail
$z = new SingletonDemo();
