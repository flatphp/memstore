<?php namespace Flatphp\Memstore;

/**
 * redis-cluster ref: https://github.com/phpredis/phpredis/blob/feature/redis_cluster/cluster.markdown#readme
 *
 * config e.g.
 * cluster:
 * array(
 *     'options' => [],
 *     //'name' => 'mycluster'
 *     'seeds' => ['host1:7000', 'host2:7001'] // name or seeds is required
 *     'timeout' => 0,
 *     'read_timeout' => 0,
 *     'persistent' => false
 * )
 */
class RedisClusterConn
{
    protected $_cluster;

    public function __construct(array $config)
    {
        if (!empty($config['name'])) {
            $this->_cluster = new \RedisCluster($config['name']);
        } else {
            $timeout = isset($config['timeout']) ? $config['timeout'] : 0;
            $read_timeout = isset($config['read_timeout']) ? $config['read_timeout'] : 0;
            $persistent = isset($config['persistent']) ? $config['persistent'] : false;
            $this->_cluster = new \RedisCluster(NULL, $config['seeds'], $timeout, $read_timeout, $persistent);
        }
        if (!empty($config['options'])) {
            foreach ($config['options'] as $k=>$v) {
                $this->_cluster->setOption($k, $v);
            }
        }
    }

    /**
     * @return \RedisCluster
     */
    public function getRedisCluster()
    {
        return $this->_cluster;
    }


    public function __call($method, $args = [])
    {
        return call_user_func_array([$this->_cluster, $method], $args);
    }
}