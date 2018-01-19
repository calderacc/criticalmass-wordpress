<?php

class Cache
{
    const TTL = 300;

    public function __construct()
    {
    }

    public function isCached($key)
    {
        return get_transient($key);
    }

    public function set($key, $data)
    {
        return set_transient($key, $data, self::TTL);
    }

    public function get($key)
    {
        return get_transient($key);
    }
}
