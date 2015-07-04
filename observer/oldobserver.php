<?php
interface IObserver
{
    function onChanged($sender, $args);
}

class UserListLogger implements IObserver
{
    public function onChanged ($sender, $args)
    {
        echo "'$args' added to user list\n";
    }
}

class UserListNotify implements IObserver
{
    public function onChanged ($sender, $args)
    {
        echo "sending welcome message to '$args' \n";
    }
}

interface IObserverable
{
    function addObserver($observer);
}

class UserList implements IOBserverable
{
    private $_observers = array();

    public function addCustomer ($name)
    {
        foreach ($this->_observers as $obs)
            $obs->onChanged($this, $name);
    }

    public function addObserver($observer)
    {
        $this->_observers[] = $observer;
    }
}


$ul = new UserList();
$ul->addObserver( new UserListLogger() );
$ul->addObserver( new UserListNotify() );
$ul->addCustomer("Jack");
