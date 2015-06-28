<?php

function __autoload($class_name) {
    include $class_name . '.php';
}

class Client
{
    private $marketer;
    private $manager;
    private $engineer;

    public function __construct() 
    {
        $this->makeConcretePrototype();

    }

    private function makeConcretePrototype()
    {
        $this->marketer = new Marketing();
        $this->manager = new Management();
        $this->engineer = new Engineering();
    }

    private function showEmployee(IACmePrototype $employeeNow)
    {
    }

    private function setEmployee(IACmePrototype $employeeNow, $nm, $dp, $id, $px)
    {
    }
}

$worker = new Client();
