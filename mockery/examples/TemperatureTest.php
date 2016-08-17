<?php
require_once "../vendor/autoload.php";
require_once "Temperature.php";
use \Mockery as m;

class TemperatureTest extends PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        m::close();
    }

    public function testGetsAverageTemperatureFromThreeServiceReadings()
    {
        $service = m::mock('service');
        $service->shouldReceive('readTemp')->times(3)->andReturn(10, 12, 14);

        $temperature = new Temperature($service);

        $this->assertEquals(12, $temperature->average());
    }

}
