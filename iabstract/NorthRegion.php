<?php

include_once("IAbstract.php");

class NorthRegion extends IAbstract
{
    protected function giveCost() {
        return 218.54;
    }

    protected function giveCity() {
        return "New York";
    }
}
