<?php

include_once('Product.php');
include_once('FormatHelper.php');

class MexicoProduct implements Product
{
    private $mfgProduct;
    private $formatHelper;

    public function getProperties() {
        $this->mfgProduct = "Something about Mexico";
        return $this->mfgProduct;
    }
}
?>
