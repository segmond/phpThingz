<?php

class FlyweightFontStyle {
    private $name;

    public function __construct($name, $size, $color) {
        $this->name = $name;
        $this->size = $size;
        $this->color = $color;
    }

    public function getName() {
        return $this->name;
    }

    public function getSize() {
        return $this->size;
    }

    public function getColor() {
        return $this->color;
    }

    public function render($ch) {
        echo "<font name='$this->name' color='$this->color' size=$this->size>$ch</font>\n";
    }
}

class FontStyleFactory {
    private $fonts;

    public function __construct() {
        $this->styles = array();
    }

    public function lookup($name, $size, $color) {
        if (!isset($this->styles["$name:$size:$color"])) {
            $this->styles["$name:$size:$color"] = new FlyweightFontStyle($name, $size, $color);
        }
        return $this->styles["$name:$size:$color"];
    }

    public function totalInsectsType() {
        return count($this->styles);
    }
}

class characterCreator {
    private $id;
    private $ch;
    private $fontType;

    public function __construct($id, $ch, FlyweightFontStyle $type) {
        $this->id = $id;
        $this->ch = $ch;
        $this->fontType = $type;
    }

    public function show() {
        echo "char id $this->id is $this->ch, and font name is  " . $this->fontType->getName() . "\n";
    }

    public function render() {
        $this->fontType->render($this->ch);
    }
}

class WordProcessor {
    private $fonts;
    private $fontFactory;

    public function __construct() {
        $this->fonts = array();
        $this->fontFactory = new FontStyleFactory();
    }

    public function addCharacter($ch, $id, $font_name, $size, $color) {
        $font = $this->fontFactory->lookup($font_name, $size, $color);
        $character = new characterCreator($id, $ch, $font);
        $this->fonts[] = $character;
    }

    public function render() {
        foreach ($this->fonts as $character) {
            $character->render();
        }
    }

    public function report() {
        echo "Total font types made: " . $this->fontFactory->totalInsectsType() . "\n";
    }

    public static function main() {
        $wp = new WordProcessor();

        $characters = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h');

        for ($i = 1; $i < 10; $i++) {
            $rand_key = array_rand($characters, 1);
            $wp->addCharacter($characters[$rand_key], $i, "Comic sans", 10, "black");
        }
        $wp->addCharacter('hello', $i++, "Comic sans", 20, "green");
        $wp->addCharacter('world', $i++, "Comic sans", 10, "black");

        $wp->render();
        $wp->report();
    }
}

WordProcessor::main();
