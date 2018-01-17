<?php

require_once __DIR__ . '/../Factory/CityFactory.php';
require_once __DIR__ . '/../Factory/RideFactory.php';

abstract class AbstractListShortcode
{
    /** @var RideFactory */
    protected $rideFactory;

    /** @var CityFactory */
    protected $cityFactory;

    public function __construct()
    {
        $this->cityFactory = new CityFactory();
        $this->rideFactory = new RideFactory();
    }
}
