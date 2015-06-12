<?php

class DoMath
{
    private $sum;
    private $quotient;

    public function simpleAdd($x, $y) {
        $this->sum = $x + $y;
        return $this->sum;
    }

    public function simpleDivide($x, $y) {
        $this->quotient = $x / $y;
        return $this->quotient;
    }
}
?>
