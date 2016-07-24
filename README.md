# Memstore
memcache, memcached, redis

# Installation
```php
composer require "flatphp/memstore"
```

# Configuration

```php
// single
\Flatphp\Memstore\Store::config(array(
    'memcache' => ['host' => '127.0.0.1', 'port' => 11211],
	'redis' => ['host' => '127.0.0.1', 'port' => '6379']
));


// cluster
\Flatphp\Memstore\Store::config(array(
    'memcache' => array(
		['host' => '127.0.0.1'],
		['host' => '127.0.0.1', 'port' => 11211]
	),
	'redis' => array(
		'cluster' => 'mycluster'
	)
));

\Flatphp\Memstore\Store::config(array(
	'redis' => array(
		'cluster' => ['localhost:7000', 'localhost2:7001', 'localhost:7002']
	)
));
```

# Usage
```php
$memcache = \Flatphp\Memstore\Store::getMemcache();
$memcached = \Flatphp\Memstore\Store::getMemcached();
$redis = \Flatphp\Memstore\Store::getRedis();

$redis->set('test', 1);
......
```