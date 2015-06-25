<?php
abstract class Creator
{
    protected abstract function factorymethod();

    public function startFactory() {
        $mfg = $this->factoryMethod();
        return $mfg;
    }
}
?>
