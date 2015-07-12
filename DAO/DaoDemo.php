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

/** Transfer object */
class User {
    public $id;
    public $username;
    public $email;
    public $age;
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

/** Concrete DAO */
class UserDAO extends AbstractPgDAO implements IUserDAO {
    protected $primaryKey = "id";
    protected $tableName = "public.user";

    public function makeUser($dbres) {
        $user = new User();
        $user->id = $dbres['id'];
        $user->username = $dbres['username'];
        $user->email = $dbres['email'];
        $user->age = $dbres['age'];
        return $user;
    }

    public function findByEmail($email) {
        $dbres = $this->find($email, 'email');
        return $this->makeUser($dbres);
    }

    public function findByAge($age) {
        $dbres = $this->find($age, 'age');
        return $this->makeUser($dbres);
    }

    public function insertUser(User $user) {
        if ($user->id != null) {
            throw new Exception("Cannot reinsert existing object");
        }
    }

    public function updateUser(User $user) {
        if ($user->id == null) {
            throw new Exception("Cannot update a new object, insert please");
        }
    }

    public function deleteUser(User $user) {
        if ($user->id != null) {
            throw new Exception("Cannot delete a new object, insert please");
        }
    }
        
}


class App {
    public static function main() {
        $userDAO = new UserDAO(DBFactory::getDB('testDB'));

        $user = $userDAO->findByEmail('john@john.com');
        var_dump($user);

        $users = $userDAO->findAll(20, 'age');
        foreach ($users as $u) {
            var_dump($userDAO->makeUser($u));
        }

        $mike = new User();
        $mike->username = 'tyson';
        $mike->email = 'mike@tyson.net';
        $mike->age = 45;

        $userDAO->insertUser($mike);
    }
}

App::main();


/**
 * http://www.oracle.com/technetwork/java/dataaccessobject-138824.html
 * http://www.tutorialspoint.com/design_pattern/data_access_object_pattern.htm
 * http://best-practice-software-engineering.ifs.tuwien.ac.at/patterns/dao.html
 */
