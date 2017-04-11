<?php
use Flatphp\Memstore\RedisConn;

class RedisConnTest extends PHPUnit_Framework_TestCase
{
    public function testConn()
    {
        return new RedisConn(array(
            'host' => '127.0.0.1',
            'port' => '6379'
        ));
    }

    /**
     * @depends testConn
     */
    public function testUse(RedisConn $redis)
    {
        $redis->getRedis()->set('_test', 1);
        $value = $redis->get('_test');
        $this->assertEquals($value, 1);
    }
}
