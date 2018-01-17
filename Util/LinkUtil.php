<?php

class LinkUtil
{
    public static function createLinkForRide(Ride $ride): string
    {
        $rideDate = $ride->getDateTime()->format('Y-m-d');

        return sprintf('https://criticalmass.in/%s/%s', $ride->getCity()->getSlug(), $rideDate);
    }

    public static function createLinkForRideEstimate(Ride $ride): string
    {
        $rideDate = $ride->getDateTime()->format('Y-m-d');

        return sprintf('https://criticalmass.in/%s/%s/anonymousestimate', $ride->getcity()->getSlug(), $rideDate);
    }

    public static function createLinkForCity(City $city): string
    {
        return sprintf('https://criticalmass.in/%s', $city->getSlug());
    }
}
