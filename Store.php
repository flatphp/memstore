<?php namespace Flatphp\Memstore;

/**
 * e.g.
 * [
 *     'redis' => [],
 *     'memcache' => []
 * ]
 */
class Store
{
    protected static $_config = [];

    public static function init(array $config)
    {
        self::$_config = $config;
    }

    /**
     * @return Redis
     */
    public static function getRedis()
    {
        static $redis = null;
        if (null === $redis) {
            if (empty(self::$_config['redis'])) {
                throw new \InvalidArgumentException('missing redis config');
            }
            $redis = new Redis(self::$_config['redis']);
        }
        return $redis;
    }

    /**
     * @return Memcache
     */
    public static function getMemcache()
    {
        static $mc = null;
        if (null === $mc) {
            if (empty(self::$_config['memcache'])) {
                throw new \InvalidArgumentException('missing memcache config');
            }
            $mc = new Memcache(self::$_config['memcache']);
        }
        return $mc;
    }

    /**
     * @return Memcached
     */
    public static function getMemcached()
    {
        static $mc = null;
        if (null === $mc) {
            if (empty(self::$_config['memcached'])) {
                throw new \InvalidArgumentException('missing memcached config');
            }
            $mc = new Memcached(self::$_config['memcached']);
        }
        return $mc;
    }
}