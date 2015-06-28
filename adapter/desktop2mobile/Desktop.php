<?php

// make an interface based on desktop so we can adapt it to mobile
interface IDesktopFormat {
    public function formatCSS();
    public function formatGraphics();
    public function horizontalLayout();
}

// mobile interface
interface IMobileFormat {
    public function formatCSS();
    public function formatGraphics();
    public function verticalLayout();
}

// we want to adapt desktop to mobile, extend the interface we created
class Desktop implements IDesktopFormat 
{
    public function formatCSS() {
        echo "css\n";
    }

    public function formatGraphics() {
        echo "graphics\n";
    }

    public function horizontalLayout() {
        echo "desktop horizontal layout\n";
    }
}

// mobile implements mobile format
class Mobile implements IMobileFormat 
{
    public function formatCSS() {
        echo "css\n";
    }

    public function formatGraphics() {
        echo "graphics\n";
    }

    public function verticalLayout() {
        echo "mobile vertical layout\n";
    }
}

class Client {
    public function __construct() 
    {
        $desktop = new Desktop();

        $desktop->formatCSS();
        $desktop->formatGraphics();
        $desktop->horizontalLayout();
    }
}

$worker = new Client();

// create the mobile adapter
// we can use a different mobile design without disrupting implementation of the original
// desktop design
class MobileAdapter implements IDesktopFormat
{
    private $mobile;

    public function __construct(IMobileFormat $mobile) {
        $this->mobile = $mobile;
    }

    public function formatCSS() { $this->mobile->formatCSS(); }

    public function formatGraphics() { $this->mobile->formatGraphics (); }

    public function horizontalLayout() { $this->mobile->verticalLayout(); }
}

// use it as if it's a desktop client
class MobileClient {
    public function __construct() 
    {
        $mobile = new MobileAdapter(new Mobile());

        $mobile->formatCSS();
        $mobile->formatGraphics();
        $mobile->horizontalLayout();
    }
}

$mobile_client = new MobileClient();
