<?php

include_once('Product.php');

class GraphicProduct implements Product
{
    private $mfgProduct;

    public function getProperties() {
        $this->mfgProduct = <<< _EOS_
<html>
    <head><title>Map Factory</title></head>
    <body>
    <img src='Mali.png' width='500' height='500' />
    </body>
</html>
_EOS_;
        return $this->mfgProduct;
    }
}
?>
