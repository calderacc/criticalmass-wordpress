<?php

class LinkUtil
{
    public static function createLinkForRide(Ride $ride)
    {
        $rideDate = $ride->getDateTime()->format('Y-m-d');

        return sprintf('https://criticalmass.in/%s/%s', $ride->getCity()->getSlug(), $rideDate);
    }

    public static function createLinkForRideEstimate(Ride $ride)
    {
        $rideDate = $ride->getDateTime()->format('Y-m-d');

        return sprintf('https://criticalmass.in/%s/%s/anonymousestimate', $ride->getcity()->getSlug(), $rideDate);
    }

    public static function createLinkForCity(City $city)
    {
        return sprintf('https://criticalmass.in/%s', $city->getSlug());
    }
}
