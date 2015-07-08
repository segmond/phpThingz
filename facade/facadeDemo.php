<?php
class Window {
    private $title;
    private $size_x, $size_y;
    private $panel;

    public function __construct() {
        $this->panel = null;
        $this->size_x = 1920;
        $this->size_y = 1024;
        $this->pos_x = 0;
        $this->pos_y = 0;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setSize($x, $y) {
        $this->size_x = $x;
        $this->size_y = $y;
    }

    public function center() {
        $this->pos_x = (1920 - $this->size_x) / 2;
        $this->pos_y = (1024 - $this->size_y) / 2;
    }

    public function getPos() {
        return "$this->pos_x, $this->pos_y";
    }

    public function show() {
        $winData = " [Window {title:'$this->title'}, size:{{$this->size_x},{$this->size_y}}";
        $winData .= " pos:{" . $this->getPos() . "}";
        if (!is_null($this->panel)) {
            $panelData = $this->panel->show();
            $winData .= "\n\t" . $panelData;
        }
        return $winData . "]";
    }
    
    public function add(Panel $p) {
        $this->panel = $p;
    }
}

class Panel {
    private $bgColor;
    private $size_x, $size_y;
    private $text;
    private $buttons;

    public function __construct() {
        $this->buttons = array();
    }
    public function setBackgroundColor($color) {
        $this->bgColor = $color;
    }

    public function setSize($x, $y) {
        $this->size_x = $x;
        $this->size_y = $y;
    }

    public function getBackgroundColor() {
        return $this->bgColor;
    }

    public function getSize() {
        return "$this->size_x, $this->size_y";
    }

    public function addText($text) {
        $this->text = $text;
    }

    public function getText() {
        return $this->text;
    }

    public function addButton($b) {
        $this->buttons[] = $b;
    }

    public function show() {
        $buttonData = null;
        foreach ($this->buttons as $button) {
            $buttonData .= " \n\t\t" . $button->show();
        }
            
        return "[ Panel {bgColor:'".$this->bgColor."'}, " .
                 "size:{".$this->getSize()."} " . 
                 "text:{{$this->text}" . $buttonData . "]";
    }
}


class Button {
    private $label;

    public function __construct($label) {
        $this->label = $label;
    }

    public function show() {
        return "[ Button {label: $this->label} ]";
    }
}

/** Facade */
class AlertBox {
    private $alertWin;
    public function __construct($alert) {  
        $window = new Window();
        $window->setTitle('Alert');
        $window->setSize(300,200);

        $panel = new Panel();
        $panel->setBackgroundColor('White');
        $panel->setSize(300,200);
        $panel->addText($alert);

        $buttonOk = new Button("Ok");
        $buttonCancel = new Button("Cancel");

        $panel->addButton($buttonOk);
        $panel->addButton($buttonCancel);

        $window->add($panel);

        $this->alertWin = $window;
    }

    public function show() {
        echo $this->alertWin->show();
    }
}


$alert = new AlertBox("Are you sure you wanna facade?");
$alert->show();
