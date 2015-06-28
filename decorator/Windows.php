<?php

interface Window {
    public function draw();
    public function getDescription();
}

class SimpleWindow implements Window {
    public function draw() {
        return "Draw simple window";
    }

    public function getDescription() {
        return "simple window";
    }
}

$s = new SimpleWindow();
echo $s->draw() . "\n";
echo $s->getDescription() . "\n";


// abstract decorator class
abstract class WindowDecorator implements Window {
    protected $window_to_be_decorated;

    public function __construct(Window $win) {
        $this->window_to_be_decorated = $win;
    }

    public function draw() {
        return $this->window_to_be_decorated->draw();
    }

    public function getDescription() {
        return $this->window_to_be_decorated->getDescription();
    }
}


class VerticalScrollBarDecorator extends WindowDecorator {
    public function __construct($win) {
        parent::__construct($win);
    }

    private function drawVerticalScrollBar() {
        return 'vertical scroll bar';
    }

    public function draw() {
        return parent::draw() . " with " .  $this->drawVerticalScrollBar();
    }

    public function getDescription() {
        return parent::getDescription() . ", including vertical scrollbars";
    }
}

class HorizontalScrollBarDecorator extends WindowDecorator {
    public function __construct($win) {
        parent::__construct($win);
    }

    private function drawHorizontalScrollBar() {
        return 'horizontal scroll bar';
    }

    public function draw() {
        return parent::draw() . " with " .  $this->drawHorizontalScrollBar();
    }

    public function getDescription() {
        return parent::getDescription() . ", including horizontal scrollbars";
    }
}

echo "\n";
$s = new VerticalScrollBarDecorator(new SimpleWindow());
echo $s->draw() . "\n";
echo $s->getDescription() . "\n";

echo "\n";
$s = new HorizontalScrollBarDecorator(new VerticalScrollBarDecorator(new SimpleWindow()));
echo $s->draw() . "\n";
echo $s->getDescription() . "\n";


