<?php
require_once('dbconf.php');

/** DB Factory */
class DBFactory 
{
    public static function getDB($dbname) {
        return new PDO("pgsql:host=localhost;
                            dbname=$dbname;
                            user=".DBUSER." 
                            password=".DBPASS);
    }
}

/* Abstract DAO */
abstract class AbstractPgDAO {
    protected $dbConn;
    protected $primaryKey;
    protected $tableName;

    public function __construct($dbConn) {
        $this->dbConn = $dbConn;
    }

    public function find($value, $key=NULL) {
        if (is_null($key)) {
            $key = $this->primaryKey;
        }
        $stmt = $this->dbConn->prepare("SELECT * FROM $this->tableName WHERE $key = :val"); 
        $stmt->execute(array(':val'=>$value));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll($value, $key=NULL) {
        if (is_null($key)) {
            $key = $this->primaryKey;
        }
        $stmt = $this->dbConn->prepare("SELECT * FROM $this->tableName WHERE $key = :val"); 
        $stmt->execute(array(':val'=>$value));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($dict) {
    }

    public function update($dict) {
    }

    public function delete($key = NULL)
    {
        if (is_null($key)) {
            $key = $this->primaryKey;
        }
        $stmt = $this->dbConn->prepare("DELETE $this->tableName WHERE id = $key"); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

/** Interface for UserDAO */
interface IUserDAO {
    function find($value, $key);
    function findAll($value, $key);
    function findByEmail($email);
    function findByAge($age);
    function insertUser(User $user);
    function updateUser(User $user);
    function deleteUser(User $user);
}

class UserDAO extends AbstractPgDAO implements IUserDAO {
    protected $primaryKey = "id";
    protected $tableName = "public.user";

    public function findByEmail($email) {
        return $this->find($email, 'email');
    }

    public function findByAge($age) {
        return $this->find($age, 'age');
    }

    public function insertUser(User $user) {
        if ($user->id != null) {
            throw new Exception("Cannot reinsert existing object");
        }
    }

    public function updateUser(User $user) {
    }

    public function deleteUser(User $user) {
    }
        
}


class User {
    public $id;
    public $username;
    public $email;
    public $age;
}

$userDAO = new UserDAO(DBFactory::getDB('testDB'));
$user = $userDAO->findByEmail('ken@ken.com');

var_dump($user);

$users = $userDAO->findAll(20, 'age');
var_dump($users);

$mike = new User();
$mike->username = 'tyson';
$mike->email = 'mike@tyson.net';
$mike->age = 45;

$userDAO->insertUser($mike);
