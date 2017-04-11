<?php
use Flatphp\Memstore\RedisClusterConn;

class RedisClusterConnTest extends PHPUnit_Framework_TestCase
{
    public function testConn()
    {
        return new RedisClusterConn(array(
            'seeds' => '127.0.0.1:7000',
        ));
    }

    /**
     * @depends testConn
     */
    public function testUse(RedisClusterConn $cluster)
    {
        $cluster->getRedisCluster()->set('_test', 1);
        $value = $cluster->get('_test');
        $this->assertEquals($value, 1);
    }
}
