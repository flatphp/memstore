<?php namespace Flatphp\Memstore;
/**
 * e.g.
 * [
 *     'memcache' => [],
 *     'memcached' => [],
 *     'redis' => [],
 *     'redis_cluster' => [],
 *     'predis' => []
 * ]
 */
class Conn
{
    protected static $_config = [];

    public static function init(array $config)
    {
        self::$_config = $config;
    }


    public static function connect($type, $config)
    {
        $type = strtolower($type);
        $type = str_replace('_', '', ucwords($type, '_'));
        $conn = __NAMESPACE__ .'\\' .$type .'Conn';
        return new $conn($config);
    }


    protected static function _conn($type, $name)
    {
        if (empty(self::$_config[$type])) {
            throw new \InvalidArgumentException('missing '. $type .' config');
        }
        $conn = __NAMESPACE__ .'\\' .$name .'Conn';
        return new $conn(self::$_config[$type]);
    }

    /**
     * @return \Redis
     */
    public static function getRedis()
    {
        static $redis = null;
        if (null === $redis) {
            $redis = self::_conn('redis', 'Redis')->getRedis();
        }
        return $redis;
    }

    /**
     * @return \RedisCluster
     */
    public static function getRedisCluster()
    {
        static $redis = null;
        if (null === $redis) {
            $redis = self::_conn('redis_cluster', 'RedisCluster')->getRedisCluster();
        }
        return $redis;
    }

    /**
     * @return \Predis\Client
     */
    public static function getPredis()
    {
        static $redis = null;
        if (null === $redis) {
            $redis = self::_conn('predis', 'Predis')->getPredis();
        }
        return $redis;
    }

    /**
     * @return \Memcache
     */
    public static function getMemcache()
    {
        static $mc = null;
        if (null === $mc) {
            $mc = self::_conn('memcache', 'Memcache')->getMemcache();
        }
        return $mc;
    }

    /**
     * @return \Memcached
     */
    public static function getMemcached()
    {
        static $mc = null;
        if (null === $mc) {
            $mc = self::_conn('memcached', 'Memcached')->getMemcached();
        }
        return $mc;
    }
}