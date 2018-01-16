<?php

class CityFactory
{
    public function __construct()
    {

    }

    public function getCityList(): array
    {
        $apiUrl = sprintf('https://criticalmass.in/api/city');
        $response = wp_remote_get($apiUrl);
        $responseCode = $response['response']['code'];

        if (200 !== $responseCode) {
            return null;
        }

        $data = json_decode($response['body']);

        return $data;
    }
}
