<?php

abstract class IAcmePrototype
{
    protected $name;
    protected $id;
    protected $employeePic;
    protected $dept;

    abstract function setDept($orgCode);
    abstract function getDept();

    public function setName($emName) {
        $this->name = $emName;
    }

    public function getName() {
        return $this->name;
    }

    public function setId($emId) {
        $this->id = $emId;
    }

    public function getId() {
        return $this->id;
    }

    public function setPic($emPic) {
        $this->employeePic = $emPic;
    }

    public function getPic() {
        return $this->employeePic;
    }

    abstract function __clone();
}
