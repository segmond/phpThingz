<?php

include_once('Creator.php');
include_once('Product.php');

class CountryFactory extends Creator
{
    private $country;

    protected function factorymethod(Product $product) {
        $this->country = $product;
        return ($this->country->getProperties());
    }
}
?>
