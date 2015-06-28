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

        $Tess = clone $this->marketer;
        $this->setEmployee($Tess, 'Tess Smith', 101, 'ts101-1234', 'tess.png');
        $this->showEmployee($Tess);

        $Jacob = clone $this->marketer;
        $this->setEmployee($Jacob, 'Jacob Jones', 102, 'jj102-2234', 'jacob.png');
        $this->showEmployee($Jacob);

        $Ricky = clone $this->manager;
        $this->setEmployee($Ricky, 'Ricky Rod', 203, 'rr102-2234', 'jacob.png');
        $this->showEmployee($Ricky);

        $Olivia = clone $this->engineer;
        $this->setEmployee($Olivia, 'Olivia Perez', 302, 'op102-2234', 'olivia.png');
        $this->showEmployee($Olivia);

        $John = clone $this->engineer;
        $this->setEmployee($John, 'John Jackson', 301, 'jj302-2234', 'john.png');
        $this->showEmployee($John);

    }

    private function makeConcretePrototype()
    {
        $this->marketer = new Marketing();
        $this->manager = new Management();
        $this->engineer = new Engineering();
    }

    private function showEmployee(IACmePrototype $employeeNow)
    {
        $px = $employeeNow->getPic();
        echo "$px\n";
        echo $employeeNow->getName() . "\n";
        echo $employeeNow->getDept() . "\n";
        echo $employeeNow->getID() . "\n";
    }

    private function setEmployee(IACmePrototype $employeeNow, $nm, $dp, $id, $px)
    {
        $employeeNow->setName($nm);
        $employeeNow->setDept($dp);
        $employeeNow->setID($id);
        $employeeNow->setPic("pix/$px");
    }
}

$worker = new Client();
