<?php
use Flatphp\Memstore\MemcachedConn;

class MemcachedConnTest extends PHPUnit_Framework_TestCase
{
    public function testConn()
    {
        return new MemcachedConn(array(
            'host' => '127.0.0.1',
            'port' => '11211'
        ));
    }

    /**
     * @depends testConn
     */
    public function testUse(MemcachedConn $mc)
    {
        $mc->getMemcached()->set('_test', 1);
        $value = $mc->get('_test');
        $this->assertEquals($value, 1);
    }
}
