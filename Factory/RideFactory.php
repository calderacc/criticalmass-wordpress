<?php

require_once __DIR__ . '/../Entity/Ride.php';
require_once __DIR__ . '/CityFactory.php';

class RideFactory
{
    /** @var CityFactory $cityFactory */
    protected $cityFactory;

    public function __construct()
    {
        $this->cityFactory = new CityFactory();
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

        $rideList = [];

        foreach ($data as $rideData) {
            $ride = $this->convert($rideData);

            $rideList[] = $ride;
        }

        return $rideList;
    }

    public function sortRideList(array $rideList, $sortFunction): array
    {
        /**
         * @var Ride $a
         * @var Ride $b
         */
        $sortFunctionList = [
            'city' => function($a, $b) {
                return $a->getCity()->getName() > $b->getCity()->getName();
            },
            'date' => function($a, $b) {
                return $a->getDateTime() > $b->getDateTime();
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

    public function convert(\stdClass $rideData): Ride
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

        if ($rideData->city) {
            $city = $this->cityFactory->convert($rideData->city);

            $ride->setCity($city);
        }

        return $ride;
    }
}
