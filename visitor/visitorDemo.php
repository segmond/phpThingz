<?php

interface ICarElementVisitor {
	function visit(ICarElement $car_element);
}

interface ICarElement {
	function accept(ICarElementVisitor $visitor);
}

abstract class AbstractCarElement implements ICarElement {
	private $name;

	public function __construct($name=null) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	abstract public function accept(ICarElementVisitor $visitor); 
}

class Wheel extends AbstractCarElement {
	public function accept(ICarElementVisitor $visitor) {
		$visitor->visit($this);
	}
}

class Engine extends AbstractCarElement {
	public function accept(ICarElementVisitor $visitor) {
		$visitor->visit($this);
	}
}

class Body extends AbstractCarElement {
	public function accept(ICarElementVisitor $visitor) {
		$visitor->visit($this);
	}
}

class Car extends AbstractCarElement {
	private $elements = array();

	public function __construct($name=null) {
		parent::__construct($name);
		$this->elements[] = new Wheel('front left');
		$this->elements[] = new Wheel('front right');
		$this->elements[] = new Wheel('back left');
		$this->elements[] = new Wheel('back right');
		$this->elements[] = new Body();
		$this->elements[] = new Engine();
	}

	public function accept(ICarElementVisitor $visitor) {
		foreach ($this->elements as $e) {
			$e->accept($visitor);
		}
		$visitor->visit($this);
	}
}

class CarElementPrintVisitor implements ICarElementVisitor {
	public function visit(ICarElement $element) {
		$class_name = get_class($element);

		switch ($class_name) {
			case "Wheel":
				echo "Visiting " . $element->getName() . " wheel\n";
				break;
			case 'Engine':
				echo "Visiting engine\n";
				break;
			case 'Body':
				echo "Visiting body\n";
				break;
			case 'Car':
				echo "Visiting car\n";
				break;
			default:
				throw new Exception("Unknown class type $class_name\n");
		}
	}
}

class CarElementDoVisitor implements ICarElementVisitor {
	public function visit(ICarElement $element) {
		$class_name = get_class($element);

		switch ($class_name) {
			case 'Wheel':
				echo "Kicking my " . $element->getName() . " wheel\n";
				break;
			case 'Engine':
				echo "Starting my engine\n";
				break;
			case 'Body':
				echo "Cleaning the body\n";
				break;
			case 'Car':
				echo "Driving my car\n";
				break;
			default:
				throw new Exception("Unknown class type $class_name\n");
		}
	}
}

class VisitorDemo {
	public static function main() {
		$car = new Car();
		$car->accept(new CarElementPrintVisitor());
		$car->accept(new CarElementDoVisitor());
	}
}

VisitorDemo::main();
