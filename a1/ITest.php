<?php

interface IInteger
{
    public function add(IInteger $a);
    public function sub(IInteger $a);
    public function mul(IInteger $a);
    public function div(IInteger $a);
}

class OurInteger implements IInteger
{
    private $val;
    function __construct($val=0) {
        if (! is_int($val)) {
            throw new Exception("Invalid integer passed to our interger");
        }
        $this->val = $val;
    }

    public function getval() {
        return $this->val;
    }

    public function add(IInteger $a) {
        $this->val += $a->getval();
    }

    public function sub(IInteger $a) {
        $this->val -= $a->getval();
    }

    public function mul(IInteger $a) {
        $this->val *= $a->getval();
    }

    public function div(IInteger $a) {
        $this->val /= $a->getval();
    }
}

$a = new OurInteger(10);
$b = new OurInteger(23);
$a->add($b);
echo "result is " . $a->getval() . "\n";
