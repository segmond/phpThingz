<?php
abstract class Creator
{
    protected abstract function factorymethod(Product $product);

    public function doFactory($product) {
        return $this->factoryMethod($product);
    }
}
?>
