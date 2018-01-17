<?php

class Api
{
    public function __construct()
    {

    }

    public function fetch(string $endpoint, array $parameter = []): ?string
    {
        $apiUrl = sprintf('https://criticalmass.in/api/%s?%s', $endpoint, http_build_query($parameter));

        $response = wp_remote_get($apiUrl);

        $responseCode = $response['response']['code'];

        if (200 !== $responseCode) {
            return null;
        }

        return $response['body'];
    }
}
