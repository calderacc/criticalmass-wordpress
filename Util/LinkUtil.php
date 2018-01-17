<?php

class LinkUtil
{
    public static function createLinkForRide(City $city, Ride $ride): string
    {
        $rideDate = $ride->getDateTime()->format('Y-m-d');

        return sprintf('https://criticalmass.in/%s/%s', $city->getSlug(), $rideDate);
    }

    public static function createLinkForRideEstimate(City $city, Ride $ride): string
    {
        $rideDate = $ride->getDateTime()->format('Y-m-d');

        return sprintf('https://criticalmass.in/%s/%s/anonymousestimate', $city->getSlug(), $rideDate);
    }

    public static function createLinkForCity(City $city): string
    {
        return sprintf('https://criticalmass.in/%s', $city->getSlug());
    }
}
