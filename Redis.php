<?php namespace Flatphp\Memstore;

/**
 * config e.g.
 * array('host' => '127.0.0.1', 'port' => '6379', 'auth' => 'xxx', 'pconnect' => false)
 * array(
 *     'cluster' => 'mycluster'
 * )
 * array(
 *     'cluster' => array(
 *         'localhost:7000', 'localhost2:7001', 'localhost:7002'
 *     )
 * )
 */
class Redis
{
    const DEFAULT_PORT = 6379;

    /**
     * @var \Redis
     */
    protected $_redis = null;

    /**
     * Create a new redis instance based on the given configuration
     * Based on the php redis extension
     *
     * @param array $config
     * @throws \BadFunctionCallException
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config)
    {
        if (!extension_loaded('redis')) {
            throw new \BadFunctionCallException('Redis extension not loaded.');
        }
        if (!empty($config['host'])) {
            $this->_redis = new \Redis;
            $host = $config['host'];
            $port = empty($config['port']) ? self::DEFAULT_PORT : $config['port'];
            if (isset($config['pconnect']) && $config['pconnect'] == true) {
                $this->_redis->pconnect($host, $port);
            } else {
                $this->_redis->connect($host, $port);
            }
            if (!empty($config['auth'])) {
                $this->_redis->auth($config['auth']);
            }
        } elseif (!empty($config['cluster'])) {
            if (is_array($config['cluster'])) {
                $this->_redis = new \RedisCluster(NULL, $config['cluster']);
            } else {
                $this->_redis = new \RedisCluster($config['cluster']);
            }
        } else {
            throw new \InvalidArgumentException('Invalid configuration');
        }
    }

    /**
     * Dynamically make a Redis command.
     * @param  string  $method
     * @param  array   $args
     * @return mixed
     */
    public function __call($method, $args = [])
    {
        return call_user_func_array([$this->_redis, $method], $args);
    }
}