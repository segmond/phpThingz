<?php
interface IObserver
{
    function update($sender, $args);
}

class UserListLogger implements IObserver
{
    public function update ($sender, $args)
    {
        echo "'$args' added to user list\n";
    }
}

class UserListNotify implements IObserver
{
    public function update ($sender, $args)
    {
        echo "sending welcome message to '$args' \n";
    }
}

interface IObserverable
{
    function registerObserver(IOBserver $observer);
}

class UserList implements IOBserverable
{
    private $_observers = array();

    public function addCustomer ($name)
    {
        $this->notify($name);
    }

    public function notify($name) {
        foreach ($this->_observers as $observer)
            $observer->update($this, $name);
    }

    public function registerObserver(IObserver $observer)
    {
        $this->_observers[] = $observer;
    }

    public function unregisterObserver(IObserver $observer)
    {
        $key = array_search($observer, $this->_observers, true);
        if ($key !== false) {
            unset($this->_observers[$key]);
        }
    }
}


$ul = new UserList();
$ull = new UserListLogger();
$uln = new UserListNotify();

$ul->registerObserver($ull);
$ul->registerObserver($uln);

$ul->addCustomer("Jack");

$ul->unregisterObserver($ull);
echo "\n";
$ul->addCustomer("Bob");
