<?php namespace Flatphp\Memstore;

/**
 * config e.g.
 * array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 1)
 * array(
 *     array('host' => '127.0.0.1')
 *     array('host' => '127.0.0.1', 'port' => 11211),
 *     array('host' => '127.0.0.1', 'weight' => 1)
 * )
 */
class Memcache
{
    const DEFAULT_PORT = 11211;
    const DEFAULT_WEIGHT = 1;

    protected $_mc = null;

    /**
     * Create a instance based on the given configuration
     * Based on php memcache extension
     *
     * @param array $config the configuration
     * @throws \BadFunctionCallException
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config)
    {
        if (!extension_loaded('memcache')) {
            throw new \BadFunctionCallException('Memcache extension not loaded');
        }
        $this->_mc = new \Memcache;
        if (isset($config['host'])) {
            $config = [$config];
        }
        foreach ($config as $server) {
            if (empty($server['host'])) {
                throw new \InvalidArgumentException('memcache host required');
            }
            $host = $server['host'];
            $port = empty($server['port']) ? self::DEFAULT_PORT : $server['port'];
            $weight = isset($server['weight']) ? (int)$server['weight'] : self::DEFAULT_WEIGHT;
            $this->_mc->addServer($host, $port, false, $weight);
        }
    }

    /**
     * Dynamically make a Memcache command.
     * @param  string  $method
     * @param  array   $args
     * @return mixed
     */
    public function __call($method, $args = [])
    {
        return call_user_func_array([$this->_mc, $method], $args);
    }
}