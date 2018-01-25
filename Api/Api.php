<?php

namespace Caldera\CriticalmassWordpress\Api;

use Caldera\CriticalmassWordpress\Cache\Cache;
use Caldera\CriticalmassWordpress\Exception\ApiException;

class Api
{
    const API_HOSTNAME = 'http://criticalmass.in/api';

    /** @var Cache $cache */
    protected $cache;

    public function __construct()
    {
        $this->cache = new Cache();
    }

    public function fetch($endpoint, array $parameter = [])
    {
        $apiUrl = sprintf('%s/%s?%s', self::API_HOSTNAME,$endpoint, http_build_query($parameter));

        /*if (!WP_DEBUG && $this->cache->isCached($apiUrl)) {
            return $this->cache->get($apiUrl);
        }*/

        $response = wp_remote_get($apiUrl);

        if (!is_array($response) || 200 !== $response['response']['code']) {
            throw new ApiException(sprintf('Api-Endpunkt %s nicht erreichbar oder ungültige Antwort', $apiUrl));
        }

        $this->cache->set($apiUrl, $response['body']);

        return $response['body'];
    }
}
