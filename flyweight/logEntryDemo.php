<?php
/*
 * @category Design Pattern Tutorial
 * @package Flyweight Sample
 * @author Dmitry Sheiko <me@dsheiko.com>
 * @link http://dsheiko.com
 */
 
/**
 * Flyweight object
 */
class LogEntry
{
    private $_message = null;
    public function  __construct($message)
    {
        $this->_message = $message;
    }
    public function getMessage(LogEntryContext $context)
    {
        return $this->_message . " " . strftime("%b %d, %Y / %H:%M:%S", $context->getTimestamp());
    }
}
class LogEntryContext
{
    private $_timestamp = null;
    public function  __construct($timestamp)
    {
        $this->_timestamp = $timestamp;
    }
    public function  getTimestamp()
    {
        return $this->_timestamp;
    }
}
/**
 * FlyweightFactory object
 */
class LogEntryFactory
{
    private static $_messages = array();
    private static $_callCount = 0;
    public static function make($message)
    {
        $hash = md5($message);
        if (!isset (self::$_messages[$hash])) {
            self::$_messages[$hash] = new LogEntry($message);
        }
        self::$_callCount ++;
        return  self::$_messages[$hash];
    }
    public static function getInstanceCount()
    {
        return count(self::$_messages);
    }
    public static function getRequestCount()
    {
        return self::$_callCount;
    }
}
 
class Logger
{
    private $_logEntries;
    private $_timeStamps;
    public function  __construct()
    {
        $this->_logEntries = new SplDoublyLinkedList();
        $this->_timeStamps = new SplDoublyLinkedList();
    }
    public function log($message)
    {
        $this->_logEntries->push(LogEntryFactory::make($message));
        $this->_timeStamps->push(new LogEntryContext(time()));
    }
    public function printMessages()
    {
        $len = $this->_logEntries->count();
        for ($i = 0; $i < $len; $i ++) {
            echo $this->_logEntries[$i]->getMessage($this->_timeStamps[$i]), "\n";
        }
    }
}
/**
 * Usage
 */
$logger = new Logger();
$logger->log('Page #1 viewed');
sleep(1);
$logger->log('Page #1 updated');
sleep(3);
$logger->log('Page #1 viewed');
sleep(1);
$logger->log('Page #1 viewed');
sleep(2);
$logger->log('Page #1 deleted');
sleep(1);
$logger->printMessages();
 
echo LogEntryFactory::getRequestCount(), " LogEntry instances were requested\n";
echo LogEntryFactory::getInstanceCount(), " LogEntry instances were really created\n";
 
