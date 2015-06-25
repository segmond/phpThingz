<?php

/** 
 * We don't want the client class to make a request directly to the product. Instead, we want the request to go 
 * through the creator interface.  Later, if we add products or factories, the client can make the same request
 * to a much richer variety of products without breaking the application.
 */

include_once('GraphicFactory.php');
include_once('TextFactory.php');

class Client
{
    private $someGraphicObject;
    private $someTextObject;

    public function __construct() {
        $this->someGraphicObject = new GraphicFactory();
        echo $this->someGraphicObject->startFactory() . "\n";

        $this->someTextObject = new TextFactory();
        echo $this->someTextObject->startFactory() . "\n";
    }
}

$worker = new Client();
?>
