<?php

/** 
 * We don't want the client class to make a request directly to the product. Instead, we want the request to go 
 * through the creator interface.  Later, if we add products or factories, the client can make the same request
 * to a much richer variety of products without breaking the application.
 */

include_once('CountryFactory.php');
include_once('GhanaProduct.php');
include_once('MexicoProduct.php');

class Client
{
    private $countryFactory;

    public function __construct() {
        $this->countryFactory = new CountryFactory();
        echo $this->countryFactory->doFactory(new GhanaProduct());
        echo $this->countryFactory->doFactory(new MexicoProduct());
    }
}

$worker = new Client();
?>
