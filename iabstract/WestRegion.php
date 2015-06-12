<?php

include_once("IAbstract.php");

class WestRegion extends IAbstract
{
    protected function giveCost() {
        $solarSavings = 2;
        $this->valueNow = 218.54/$solarSavings;
        return $this->valueNow;
    }

    protected function giveCity() {
        return "Toronto";
    }
}
