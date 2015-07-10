<?php

interface Order {
    public function execute();
}

// Receiver
class Stock {
    private $name;
    private $quantity;

    public function __construct($name, $quantity) {
        $this->name = $name;
        $this->quantity = $quantity;
    }

    public function buy() {
        echo "You bought $this->quantity of $this->name\n";
    }
    public function sell() {
        echo "You sold $this->quantity of $this->name\n";
    }
}

// Invoker
class Agent {
    private $ordersQueue;
    
    public function __construct() {
        $this->ordersQueue = array();
    }
    public function placeOrder(Order $order) {
        $this->ordersQueue[] = $order;
        $order->execute();
    }
}

// ConcreteCommand Class
class BuyStockOrder implements Order {
    private $stock;
    public function __construct(Stock $st) {
        $this->stock = $st;
    }
    public function execute() {
        $this->stock->buy();
    }
}
class SellStockOrder implements Order {
    private $stock;
    public function __construct(Stock $st) {
        $this->stock = $st;
    }
    public function execute() {
        $this->stock->sell();
    }
}


// Client
$ge_stock = new Stock('GE', 10);
$msft_stock = new Stock('MSFT', 20);
$bsc = new BuyStockOrder($msft_stock);
$ssc = new SellStockOrder($ge_stock);

$agent = new Agent();
$agent->placeOrder($bsc); // buy shares
$agent->placeOrder($ssc); // sell shares
