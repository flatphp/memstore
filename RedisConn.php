<?php namespace Flatphp\Memstore;

/**
 * redis ref: https://github.com/phpredis/phpredis#connection
 *
 * config e.g.
 * redis:
 * array(
 *     'options' => [],
 *
 *      'host' => '127.0.0.1',  // required
 *      'port' => '6379',  // required
 *      'password' => 'xxx',
 *      'persistent' => false,
 *      'database' => 0,
 *      'timeout' => 0
 * )
 */
class RedisConn
{
    protected $_redis;

    public function __construct(array $config)
    {
        $this->_redis = new \Redis();
        $timeout = isset($config['timeout']) ? $config['timeout'] : 0;
        if (isset($config['persistent']) && $config['persistent'] == true) {
            $this->_redis->pconnect($config['host'], $config['port'], $timeout);
        } else {
            $this->_redis->connect($config['host'], $config['port'], $timeout);
        }
        if (!empty($config['password'])) {
            $this->_redis->auth($config['password']);
        }
        if (!empty($config['options'])) {
            foreach ($config['options'] as $k=>$v) {
                $this->_redis->setOption($k, $v);
            }
        }
        if (isset($config['database'])) {
            $this->_redis->select($config['database']);
        }
    }


    /**
     * @return \Redis
     */
    public function getRedis()
    {
        return $this->_redis;
    }


    public function __call($method, $args = [])
    {
        return call_user_func_array([$this->_redis, $method], $args);
    }
}