<?php

class RideFactory
{
    public function __construct()
    {

    }

    public function getCurrentRideForCitySlug(string $citySlug): ?\stdClass
    {
        $apiUrl = sprintf('https://criticalmass.in/api/%s/current', $citySlug);
        $response = wp_remote_get($apiUrl);
        $responseCode = $response['response']['code'];

        if (200 !== $responseCode) {
            return null;
        }

        $data = json_decode($response['body']);

        return $data;
    }
}
