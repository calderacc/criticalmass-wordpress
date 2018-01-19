<?php

require_once __DIR__ . '/../Entity/City.php';
require_once __DIR__ . '/../Api/Api.php';

class CityFactory
{
    /** @var Api $api */
    protected $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getCityList()
    {
        $data = json_decode($this->api->fetch('city'));

        return $data;
    }

    public function convert(\stdClass $cityData)
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
