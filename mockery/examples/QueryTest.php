<?php
class Query
{

    public function __construct($dbconn)
    {
        $this->dbconn = $dbconn;
    }

    public function isUserLoggedIn($user_id)
    {
	$sql = "SELECT * from user_table WHERE user_id = :user AND user_logged_In";
	$res = $this->dbconn->query($sql);
	return $res;
    }

}

require_once "../vendor/autoload.php";
//require_once "Query.php";
use \Mockery as m;

class QueryTest extends PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        m::close();
    }

    public function testisUserLoggedIn()
    {
        $dbconn = m::mock('dbconn');
        $dbconn->shouldReceive('query')->times(1)->andReturn(true);

        $query = new Query($dbconn);
	$user_id = 1;
        $this->assertEquals(true, $query->isUserLoggedIn($user_id));
    }

}
