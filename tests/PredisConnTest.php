<?php
use Flatphp\Memstore\PredisConn;

class PredisConnTest extends PHPUnit_Framework_TestCase
{
    public function testConn()
    {
        return new PredisConn(array(
            'host' => '127.0.0.1',
            'port' => '6379'
        ));
    }

    /**
     * @depends testConn
     */
    public function testUse(PredisConn $redis)
    {
        $redis->getPredis()->set('_test', 1);
        $value = $redis->get('_test');
        $this->assertEquals($value, 1);
    }
}
