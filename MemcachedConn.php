<?php namespace Flatphp\Memstore;

/**
 * assemble memcache or memcached
 *
 * config e.g.
 * array(
 *     'options' = [],
 *     'persistent_id' => 'mc',
 *     'host' => 'localhost', // required
 *     'port' => 11211, // required
 *     'weight' => 0
 * )
 *
 * array(
 *     'options' = [],
 *     'persistent_id' => '',
 *     array('host' => 'host1', 'port' => 11211, 'weight' => 1),
 *     array('host' => 'host2', 'port' => 11211, 'weight' => 1)
 * )
 *
 */
class MemcachedConn
{
    /**
     * @var \Memcached
     */
    protected $_mc;
    protected $_options = array(
        \Memcached::OPT_LIBKETAMA_COMPATIBLE => true
    );

    public function __construct(array $config, $persistent_id = null)
    {
        if (!$persistent_id && !empty($config['persistent_id'])) {
            $persistent_id = $config['persistent_id'];
            unset($config['persistent_id']);
        }
        if ($persistent_id) {
            $this->_mc = new \Memcached($persistent_id);
        } else {
            $this->_mc = new \Memcached();
        }
        if (!empty($config['options'])) {
            $this->_options = array_diff_key($this->_options, $config['options']) + $config['options'];
            unset($config['options']);
        }
        if (isset($config['host'])) {
            $config = [$config];
        }
        if (!count($this->_mc->getServerList())) {
            foreach ($config as $server) {
                $weight = isset($server['weight']) ? (int)$server['weight'] : 0;
                $this->_mc->addServer($server['host'], $server['port'], $weight);
            }
        }
    }

    /**
     * @return \Memcached
     */
    public function getMemcached()
    {
        return $this->_mc;
    }


    public function __call($method, $args = [])
    {
        return call_user_func_array([$this->_mc, $method], $args);
    }
}