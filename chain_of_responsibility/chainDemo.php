<?php

abstract class PurchasePower
{
    private static $baseAmt = 500;
    protected $successor;

    public function getBase() {  
        return self::$baseAmt;
    }

    public function setSuccessor(PurchasePower $successor) {
        $this->successor = $successor;
    }

    abstract public function processRequest(PurchaseRequest $request);
}

class ManagerPPower extends PurchasePower 
{
    private $ALLOWABLE; 

    public function processRequest(PurchaseRequest $request) {
        $this->ALLOWABLE = 10 * $this->getBase();
        if ($request->getAmount() < $this->ALLOWABLE) {
            echo "Manager will approve $" . $request->getAmount() . "\n";
        } else if ($this->successor != null) {
            $this->successor->processRequest($request);
        }
    }
}

class DirectorPPower extends PurchasePower 
{
    private $ALLOWABLE; 

    public function processRequest(PurchaseRequest $request) {
        $this->ALLOWABLE = 20 * $this->getBase();
        if ($request->getAmount() < $this->ALLOWABLE) {
            echo "Director will approve $" . $request->getAmount() . "\n";
        } else if ($this->successor != null) {
            $this->successor->processRequest($request);
        }
    }
}
class VicePresidentPPower extends PurchasePower 
{
    private $ALLOWABLE; 

    public function processRequest(PurchaseRequest $request) {
        $this->ALLOWABLE = 40 * $this->getBase();
        if ($request->getAmount() < $this->ALLOWABLE) {
            echo "VicePresident will approve $" . $request->getAmount() . "\n";
        } else if ($this->successor != null) {
            $this->successor->processRequest($request);
        }
    }
}
class PresidentPPower extends PurchasePower 
{
    private $ALLOWABLE; 

    public function processRequest(PurchaseRequest $request) {
        $this->ALLOWABLE = 60 * $this->getBase();
        if ($request->getAmount() < $this->ALLOWABLE) {
            echo "President will approve $" . $request->getAmount() . "\n";
        } else {
            echo "Your request for $" . $request->getAmount() . " needs a board meeting\n";
        }
    }
}


class PurchaseRequest 
{
    private $amount;
    private $purpose;

    public function __construct($amount, $purpose) {
        $this->amount = $amount;
        $this->purpose = $purpose;
    }

    public function getAmount() {
        return $this->amount;
    }
    public function setAmount($amt) {
        $this->amount = $amt; 
    }
    public function getPurpose() {
        return $this->purpose;
    }
    public function setPurpose($reason) {
        $this->purpose = $reason; 
    }
}


class CheckAuthority
{
    public static function main() {
        $manager = new ManagerPPower();
        $director = new DirectorPPower();
        $vp = new VicePresidentPPower();
        $president = new PresidentPPower();

        $manager->setSuccessor($director);
        $director->setSuccessor($vp);
        $vp->setSuccessor($president);

        try {
            while (true) {
                echo "Enter the amount to check who should approve your expenditure.\n";
                echo "> ";
                $d = trim(fgets(STDIN));
                echo "got $d\n";
                $manager->processRequest(new PurchaseRequest($d, "General"));
            } 
        } catch (Exception $e) {
                exit();
        }
    }
}

CheckAuthority::main();
