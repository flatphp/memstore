# Memstore
Memcache, Memcached, Redis, RedisCluster, Predis

# Installation
```php
composer require "flatphp/memstore"
```

# Usage

```php
use Flatphp\Memstore\Conn;

// single
Conn::init(array(
    'memcache' => ['host' => '127.0.0.1', 'port' => 11211],
    'memcached' => ['host' => '127.0.0.1', 'port' => 11211],
    'redis' => ['host' => '127.0.0.1', 'port' => '6379'],
    'redis_cluster' => ['seeds' => ['host1:7001', 'host2:7002']],
    'predis' => ['host' => '127.0.0.1', 'port' => '6379'],
));

$memcache = Conn::getMemcache();
$memcached = Conn::getMemcached();
$redis = Conn::getRedis();
$redis_cluster = Conn::getRedisCluster();
$predis = Conn::getPredis();

$redis->set('test', 1);
......
```

# Configuration
## Memcache
```php
  // single:
  array(
      'host' => '127.0.0.1',  // required
      'port' => 11211,  // required
      'persistent' => true,
      'weight' => 1,
      # 'timeout' => 1,
      # 'retry_interval' => 15,
      # 'status' => true,
      # 'failure_callback' => null
  )
 
  // multi:
  array(
      array('host' => 'host1', ......),
      array('host' => 'host2', ......)
  )
......
```

## Memcached
```php
  array(
      'options' = [],
      'persistent_id' => 'mc',
      'host' => 'localhost', // required
      'port' => 11211, // required
      'weight' => 0
  )
 
  array(
      'options' = [],
      'persistent_id' => '',
      array('host' => 'host1', 'port' => 11211, 'weight' => 1),
      array('host' => 'host2', 'port' => 11211, 'weight' => 1)
  )
```

## Redis
```php
  array(
      'options' => [],
 
       'host' => '127.0.0.1',  // required
       'port' => '6379',  // required
       'password' => 'xxx',
       'persistent' => false,
       'database' => 0,
       'timeout' => 0
  )
```

## RedisCluster
```php
  array(
      'options' => [],
      //'name' => 'mycluster'
      'seeds' => ['host1:7000', 'host2:7001'] // name or seeds is required
      'timeout' => 0,
      'read_timeout' => 0,
      'persistent' => false
  )
```

## Predis
```php
  array(
      'options' => [],
       'host' => '127.0.0.1',
       'port' => '6379',
       'password' => 'xxx',
       'persistent' => false,
       'database' => 0,
       'timeout' => 0
  )
 
  array(
      'options' => [],
      array(
           'host' => '127.0.0.1',
           'port' => '6379',
           'password' => 'xxx',
           'persistent' => false,
           'database' => 0,
           'timeout' => 0
      ),
      array(
           'host' => '127.0.0.1',
           ......
      )
  )
```