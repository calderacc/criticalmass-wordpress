<?php

namespace Caldera\CriticalmassWordpress\Shortcode;

use Caldera\CriticalmassWordpress\Factory\CityFactory;
use Caldera\CriticalmassWordpress\Factory\RideFactory;

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
