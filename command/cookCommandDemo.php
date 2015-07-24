<?php

/** the command interface */
interface Command {
    function execute();
}

/** the invoker class */
class Waiter {
    public function takeOrder(Command $cmd) {
        $cmd->execute();
    }
}

class Chef {
    public function cook(Command $cmd) {
        $cmd->execute();
    }
}

/** The receiver class */
class Check {
    private $orders = array();

    public function addOrder($order) {
        echo "adding $order to check\n";
        $this->orders[] = $order;
    }

    public function getOrders() {
        return $this->orders;
    }
    public function listOrder() {
        foreach ($this->orders as $order) {
            echo "$order : ";
        }
        echo "\n";
    }
}

abstract class FoodOrder implements Command {
    private $check;
    
    public function __construct(Check $check) {
        $this->check = $check;
    }

    public function execute() {
        $this->check->addOrder($this->getName());
    }

    public function getName() {
        return $this->name;
    }
}

/** command for ordering salad */
class SaladOrder extends FoodOrder {
    protected $name = 'salad';
}
class PastaOrder extends FoodOrder {
    protected $name = 'pasta';
}
class IceCreamOrder extends FoodOrder {
    protected $name = 'icecream';
}
class CakeOrder extends FoodOrder {
    protected $name = 'cake';
}
class PizzaOrder extends FoodOrder {
    protected $name = 'pizza';
}

class MakeFood implements Command {
    private $check;
    public function __construct(Check $check) {
        $this->check = $check;
    }

    public function execute() {
        foreach ($this->check->getOrders() as $food_item) {
            echo "Making $food_item\n";
        }
    }
}


class DinerDemo {
    public static function main() {
        $check = new Check();      
        $pizza_check = new Check();

        $salad_order = new SaladOrder($check);
        $pasta_order = new PastaOrder($check);
        $ice_cream_order = new IceCreamOrder($check);
        $cake_order = new CakeOrder($check);

        $waiter = new Waiter();

        $waiter->takeOrder($salad_order);
        $waiter->takeOrder($pasta_order);
        $waiter->takeOrder($ice_cream_order);
        $waiter->takeOrder($cake_order);

        $pizza_order= new PizzaOrder($pizza_check);
        $waiter->takeOrder($pizza_order);

        $check->listOrder();
        $pizza_check->listOrder();

        $cook_pizza = new MakeFood($pizza_check);
        $chef = new Chef();
        $chef->cook($cook_pizza);

        $cook_a_storm = new MakeFood($check);
        $chef = new Chef();
        $chef->cook($cook_a_storm);
    }
}
DinerDemo::main();
