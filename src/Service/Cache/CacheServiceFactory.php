<?php

namespace App\Service\Cache;

class CacheServiceFactory
{
    /**
     * getCacheProvider
     *
     * @param  mixed $providerName
     * @return void
     */
    public function getCacheProvider(string $providerName)
    {
        switch ($providerName) {
            case "Redis":
                return new Redis();
        }
    }
}
