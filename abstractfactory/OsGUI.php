<?php

interface Button {
    function paint();
}

interface Label {
    function paint();
}

interface GUIFactory {
    public function createButton();
    public function createLabel();
}

class WinButton implements Button {
    function paint() {
        echo "WinButton\n";
    }
}

class WinLabel implements Label {
    function paint() {
        echo "WinLabel\n";
    }
}

class WinFactory implements GUIFactory {
    public function createButton() {
        return new WinButton();
    }

    public function createLabel() {
        return new WinLabel();
    }
}

class OSXButton implements Button {
    function paint() {
        echo "OSXButton\n";
    }
}

class OSXLabel implements Label {
    function paint() {
        echo "OSXLabel\n";
    }
}

class OSXFactory implements GUIFactory {
    public function createButton() {
        return new OSXButton();
    }

    public function createLabel() {
        return new OSXLabel();
    }
}

class LinuxButton implements Button {
    function paint() {
        echo "LinuxButton\n";
    }
}

class LinuxLabel implements Label {
    function paint() {
        echo "LinuxLabel\n";
    }
}

class LinuxFactory implements GUIFactory {
    public function createButton() {
        return new LinuxButton();
    }

    public function createLabel() {
        return new LinuxLabel();
    }
}


class Application {
    public function __construct(GUIFactory $factory) {
        $button = $factory->createButton();
        $label = $factory->createLabel();
        
        $button->paint();
        $label->paint();
    }
}


$app = new Application(new OSXFactory());
//$app = new Application(new LinuxFactory());
