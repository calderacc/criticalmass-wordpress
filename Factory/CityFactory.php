<?php

require_once __DIR__ . '/../Entity/City.php';

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

    public function convert(\stdClass $cityData): City
    {
        $city = new City();

        $city
            ->setSlug($cityData->mainSlug->slug)
            ->setName($cityData->name)
            ->setDescription($cityData->description)
            ->setLatitude($cityData->latitude)
            ->setLongitude($cityData->longitude)
        ;

        return $city;
    }
}
