<?php
use Flatphp\Memstore\Conn;

class ConnTest extends PHPUnit_Framework_TestCase
{
    public function testConn()
    {
        Conn::init(array(
            'redis' => array(
                'host' => '127.0.0.1',
                'port' => '6379'
            )
        ));

        return Conn::getRedis();
    }

    /**
     * @depends testConn
     */
    public function testUse(\Redis $redis)
    {
        $redis->set('_test', 2);
        $value = $redis->get('_test');
        $this->assertEquals($value, 2);
    }
}
