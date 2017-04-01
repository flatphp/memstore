# Memstore
memcache, memcached, redis

# Installation
```php
composer require "flatphp/memstore"
```

# Configuration

```php
use Flatphp\Memstore\Store as Memstore;

// single
Memstore::init(array(
    'memcache' => ['host' => '127.0.0.1', 'port' => 11211],
    'redis' => ['host' => '127.0.0.1', 'port' => '6379']
));


// cluster
Memstore::init(array(
    'memcache' => array(
        ['host' => '127.0.0.1'],
        ['host' => '127.0.0.1', 'port' => 11211]
    ),
    'redis' => array(
        'cluster' => 'mycluster'
    )
));

Memstore::init(array(
    'redis' => array(
        'cluster' => ['localhost:7000', 'localhost2:7001', 'localhost:7002']
    )
));
```

# Usage
```php
use Flatphp\Memstore\Store as Memstore;

$memcache = Memstore::getMemcache();
$memcached = Memstore::getMemcached();
$redis = Memstore::getRedis();

$redis->set('test', 1);
......
```