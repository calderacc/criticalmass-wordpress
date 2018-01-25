<?php

namespace Caldera\CriticalmassWordpress\Factory;

use Caldera\CriticalmassWordpress\Api\Api;
use Caldera\CriticalmassWordpress\Entity\Ride;
use Caldera\CriticalmassWordpress\Exception\InvalidParameterException;

class RideFactory
{
    /** @var CityFactory $cityFactory */
    protected $cityFactory;

    /** @var Api $api */
    protected $api;

    public function __construct()
    {
        $this->cityFactory = new CityFactory();
        $this->api = new Api();
    }

    public function fetchRideData($year = null, $month = null, $day = null, $citySlug = null, $regionSlug = null)
    {
        $parameters = [
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'city' => $citySlug,
            'region' => $regionSlug,
        ];

        $data = json_decode($this->api->fetch('ride', $parameters));

        $rideList = [];

        foreach ($data as $rideData) {
            $ride = $this->convert($rideData);

            $ride = $this->ensureTitle($ride);

            $rideList[] = $ride;
        }

        return $rideList;
    }

    public function sortRideList(array $rideList, $sortFunction, $sortOrder)
    {
        if ('asc' === $sortOrder) {
            $compareFunction = function ($a, $b) {
                return $a > $b;
            };
        } else {
            $compareFunction = function ($a, $b) {
                return $a < $b;
            };
        }

        /**
         * @var Ride $a
         * @var Ride $b
         */
        $sortFunctionList = [
            'city' => function($a, $b) use ($compareFunction) {
                return $compareFunction($a->getCity()->getName(), $b->getCity()->getName());
            },
            'date' => function($a, $b) use ($compareFunction) {
                return $compareFunction($a->getDateTime(), $b->getDateTime());
            },
            'estimation' => function($a, $b) use ($compareFunction) {
                return $compareFunction($a->getEstimatedParticipants(), $b->getEstimatedParticipants());
            }
        ];

        if (array_key_exists($sortFunction, $sortFunctionList)) {
            usort($rideList, $sortFunctionList[$sortFunction]);
        } else {
            throw new InvalidParameterException(sprintf('Ungültige Sortierfunktion: %s', $sortFunction));
        }

        return $rideList;
    }

    public function getCurrentRideForCitySlug($citySlug)
    {
        $data = json_decode($this->api->fetch(sprintf('%s/current', $citySlug)));

        $ride = $this->convert($data);
        $ride = $this->ensureTitle($ride);

        return $ride;
    }

    public function ensureTitle(Ride $ride)
    {
        if (!$ride->getTitle()) {
            $title = sprintf('Critical Mass %s', $ride->getCity()->getName());

            $ride->setTitle($title);
        }

        return $ride;
    }

    public function convert(\stdClass $rideData)
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
            ->setEstimatedParticipants($rideData->estimatedParticipants)
        ;

        if ($rideData->city) {
            $city = $this->cityFactory->convert($rideData->city);

            $ride->setCity($city);
        }

        return $ride;
    }
}
