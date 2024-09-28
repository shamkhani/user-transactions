<?php

namespace App\Service\Cache;

interface CacheServiceInterface
{
    public static function getInstance();
    public function get(string $name);
    public function set(string $name, string $value, ?int $ttl = null);
    public function del(string $name);
}
