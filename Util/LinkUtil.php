<?php

namespace Caldera\CriticalmassWordpress\Util;

use Caldera\CriticalmassWordpress\Entity\City;
use Caldera\CriticalmassWordpress\Entity\Ride;

class LinkUtil
{
    const HOSTNAME = 'https://criticalmass.in';

    public static function createLinkForRide(Ride $ride): string
    {
        $rideDate = $ride->getDateTime()->format('Y-m-d');

        return sprintf('%s/%s/%s', self::HOSTNAME, $ride->getCity()->getSlug(), $rideDate);
    }

    public static function createLinkForRideEstimate(Ride $ride): string
    {
        $rideDate = $ride->getDateTime()->format('Y-m-d');

        return sprintf('%s/%s/%s/anonymousestimate', self::HOSTNAME, $ride->getcity()->getSlug(), $rideDate);
    }

    public static function createLinkForCity(City $city): string
    {
        return sprintf('%s/%s', self::HOSTNAME, $city->getSlug());
    }
}
