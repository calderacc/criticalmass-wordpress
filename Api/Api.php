<?php

require_once __DIR__ . '/../Cache/Cache.php';

class Api
{
    /** @var Cache $cache */
    protected $cache;

    public function __construct()
    {
        $this->cache = new Cache();
    }

    public function fetch(string $endpoint, array $parameter = []): ?string
    {
        $apiUrl = sprintf('https://criticalmass.in/api/%s?%s', $endpoint, http_build_query($parameter));

        if ($this->cache->isCached($apiUrl)) {
            return $this->cache->get($apiUrl);
        }

        $response = wp_remote_get($apiUrl);

        $responseCode = $response['response']['code'];

        if (200 !== $responseCode) {
            return null;
        }

        $this->cache->set($apiUrl, $response['body']);

        return $response['body'];
    }
}
