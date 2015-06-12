<?php

abstract class IABstract
{
    protected $valueNow;

    abstract protected function giveCost();
    abstract protected function giveCity();

    public function displayShow()
    {
        $stringCost = $this->giveCost();
        $stringCost = (string) $stringCost;
        $allTogether = ("Cost: $" . $stringCost . " for " . $this->giveCity());
        return $allTogether;
    }
}
