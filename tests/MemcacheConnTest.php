<?php
use Flatphp\Memstore\MemcacheConn;

class MemcacheConnTest extends PHPUnit_Framework_TestCase
{
    public function testConn()
    {
        return new MemcacheConn(array(
            'host' => '127.0.0.1',
            'port' => '11211'
        ));
    }

    /**
     * @depends testConn
     */
    public function testUse(MemcacheConn $mc)
    {
        $mc->getMemcache()->set('_test', 1);
        $value = $mc->get('_test');
        $this->assertEquals($value, 1);
    }
}
