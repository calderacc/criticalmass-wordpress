<?php

require_once __DIR__ . '/../Entity/Ride.php';

class RideFactory
{
    public function __construct()
    {

    }

    public function fetchRideData(int $year, int $month, int $day = null, string $citySlug = null, string $regionSlug = null): ?array
    {
        $parameters = [
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'city' => $citySlug,
            'region' => $regionSlug,
        ];

        $apiUrl = sprintf('https://criticalmass.in/api/ride/?%s', http_build_query($parameters));

        $response = wp_remote_get($apiUrl);

        $responseCode = $response['response']['code'];

        if (200 !== $responseCode) {
            return null;
        }

        $data = json_decode($response['body']);

        return $data;
    }

    public function sortRideList(array $rideList, $sortFunction): array
    {
        $sortFunctionList = [
            'city' => function($a, $b) {
                return $a->city->name > $b->city->name;
            },
            'date' => function($a, $b) {
                return $a->dateTime > $b->dateTime;
            }
        ];

        if (array_key_exists($sortFunction, $sortFunctionList)) {
            usort($rideList, $sortFunctionList[$sortFunction]);
        }

        return $rideList;
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
