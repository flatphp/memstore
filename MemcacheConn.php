<?php namespace Flatphp\Memstore;

/**
 * config e.g.
 * single:
 * array(
 *     'host' => '127.0.0.1',  // required
 *     'port' => 11211,  // required
 *     'persistent' => true,
 *     'weight' => 1,
 *     # 'timeout' => 1,
 *     # 'retry_interval' => 15,
 *     # 'status' => true,
 *     # 'failure_callback' => null
 * )
 *
 * array(
 *     array('host' => 'host1', ......),
 *     array('host' => 'host2', ......)
 * )
 *
 */
class MemcacheConn
{
    /**
     * @var \Memcache
     */
    protected $_mc;

    public function __construct(array $config)
    {
        $this->_mc = new \Memcache();
        if (isset($config['host'])) {
            $config = [$config];
        }
        foreach ($config as $server) {
            $params = array(
                'host' => '127.0.0.1',
                'port' => 11211,
                'persistent' => true,
                'weight' => 1
            );
            $params = array_merge($params, $server);
            call_user_func_array([$this->_mc, 'addServer'], $params);
        }
    }

    /**
     * @return \Memcache
     */
    public function getMemcache()
    {
        return $this->_mc;
    }


    public function __call($method, $args = [])
    {
        return call_user_func_array([$this->_mc, $method], $args);
    }
}