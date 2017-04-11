<?php namespace Flatphp\Memstore;
use Predis\Client;

/**
 * Predis autoload required
 *
 * predis ref: https://github.com/nrk/predis/wiki/Connection-Parameters
 *
 * config e.g.
 * predis:
 * array(
 *     'options' => [],
 *      'host' => '127.0.0.1',
 *      'port' => '6379',
 *      'password' => 'xxx',
 *      'persistent' => false,
 *      'database' => 0,
 *      'timeout' => 0
 * )
 *
 * array(
 *     'options' => [],
 *     array(
 *          'host' => '127.0.0.1',
 *          'port' => '6379',
 *          'password' => 'xxx',
 *          'persistent' => false,
 *          'database' => 0,
 *          'timeout' => 0
 *     )
 * )
 */
class PredisConn
{
    /**
     * @var Client
     */
    protected $_predis;

    public function __construct(array $config)
    {
        $options = empty($config['options']) ? null : $config['options'];
        unset($config['options']);
        $this->_predis = new Client($config, $options);
    }

    /**
     * @return Client
     */
    public function getPredis()
    {
        return $this->_predis;
    }


    public function __call($method, $args = [])
    {
        return call_user_func_array([$this->_predis, $method], $args);
    }
}