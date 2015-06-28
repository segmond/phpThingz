<?php
abstract class CloneMe
{
    public $name;
    public $picture;

    abstract function __clone();
}

class Person extends CloneMe
{
    public function __construct()
    {
        echo "---\n";
        $this->picture = "cloneMan.png";
        $this->name = "Original";
    }

    public function display()
    {
        echo "<img src='$this->picture'>\n";
        echo "<br />$this->name <p />\n";
    }

    function __clone() { 
        echo "....\n";
    }
}

$worker = new Person();
$worker->display();

$slacker = clone $worker;
$slacker->name = "Cloned";
$slacker->display();
