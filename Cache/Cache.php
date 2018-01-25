<?php

namespace Caldera\CriticalmassWordpress\Cache;

class Cache
{
    const TTL = 300;

    public function __construct()
    {
    }

    public function isCached(string $key): bool
    {
        return get_transient($key);
    }

    public function set(string $key, string $data): bool
    {
        return set_transient($key, $data, self::TTL);
    }

    public function get(string $key): ?string
    {
        return get_transient($key);
    }
}
