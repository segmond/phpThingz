<?php

/** expensive object */
class PooledObject {
    private $id;
    public $tempdata;

    public function __construct($id) {
        $this->id = $id;
    }

    public function getID() {
        return $this->id;
    }

    public function setTestData($data) {
        $this->tempdata = $data;
    }

    public function getTestData() {
        return $this->tempdata;
    }
}


class Pool {
    private static $available = array();
    private static $inuse = array();

    public static function getObject() {
        static $foo = 0;

            if (count(self::$available) != 0) {
                $po = array_shift(self::$available);
                $inuse[] = $po;
                return $po;
            }else {
                $po = new PooledObject($foo++);
                $inuse[] = $po;
                return $po;
            }
    }

    public static function ReleaseObject(PooledObject $po) {
        self::cleanup($po);
            self::$available[] = $po;

            $key = array_search($po, self::$inuse, true);
            if ($key !== false) {
                unset(self::$inuse[$key]);
            }
    }

    public static function cleanup(PooledObject $po) {
        $po->tempdata = null;
    }
}

$p1 = Pool::getObject();
$p2 = Pool::getObject();
$p3 = Pool::getObject();
echo "Pool id is "; echo $p1->getID(); echo "\n";
echo "Pool id is "; echo $p2->getID(); echo "\n";
echo "Pool id is "; echo $p3->getID(); echo "\n";
$p1->setTestData('hello one');
echo "Pool data is "; echo $p1->getTestData(); echo "\n";
Pool::releaseObject($p1);
$p4 = Pool::getObject();
echo "Pool id is "; echo $p4->getID(); echo "\n";
echo "Pool data is "; echo $p4->getTestData(); echo "\n";
