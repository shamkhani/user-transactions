<?php

namespace App\Service\Cache;

use Predis;

class Redis implements CacheServiceInterface
{
    private static $instance = null;

    /**
     * get an Instance of Redis Client
     *
     * @return void
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Predis\Client([
                'scheme' => 'tcp',
                'host'   => 'localhost',
                'port'   => 6379,
            ]);
        }
        return self::$instance;
    }
    /**
     * get
     *
     * @param  mixed $name
     * @return void
     */
    public function get(string $name)
    {
        self::getInstance();
        return self::$instance->get($name);
    }
    /**
     * set
     *
     * @param  mixed $name
     * @param  mixed $value
     * @param  mixed $ttl
     * @return void
     */
    public function set(string $name, string $value, ?int $ttl = null)
    {
        self::getInstance();
        self::$instance->set($name, $value);
        if ($ttl) {
            self::$instance->expire($name, $ttl);
        }
    }
    /**
     * del
     *
     * @param  mixed $name
     * @return void
     */
    public function del(string $name)
    {
        self::getInstance();
        self::$instance->del($name);
    }
}
