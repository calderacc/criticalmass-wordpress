<?php

require_once __DIR__ . '/../Entity/Ride.php';

class RideFactory
{
    public function __construct()
    {

    }

    public function getCurrentRideForCitySlug(string $citySlug): ?Ride
    {
        $apiUrl = sprintf('https://criticalmass.in/api/%s/current', $citySlug);
        $response = wp_remote_get($apiUrl);
        $responseCode = $response['response']['code'];

        if (200 !== $responseCode) {
            return null;
        }

        $data = json_decode($response['body']);

        $ride = $this->convert($data);

        return $ride;
    }

    protected function convert(\stdClass $rideData): Ride
    {
        $dateTime = new \DateTime(sprintf('@%d', $rideData->dateTime));

        $ride = new Ride();

        $ride
            ->setTitle($rideData->title)
            ->setDescription($rideData->description)
            ->setLocation($rideData->location)
            ->setDateTime($dateTime)
            ->setLatitude($rideData->latitude)
            ->setLongitude($rideData->longitude)
        ;

        return $ride;
    }
}
