<?php

namespace Caldera\CriticalmassWordpress\Entity;

use DateTime;

class Ride
{
    /** @var City $city */
    protected $city;

    /** @var string $title */
    protected $title;

    /** @var string $description */
    protected $description;

    /** @var string $location */
    protected $location;

    /** @var \DateTime $dateTime */
    protected $dateTime;

    /** @var float $latitude */
    protected $latitude;

    /** @var float $longitude */
    protected $longitude;

    /** @var int $estimatedParticipants */
    protected $estimatedParticipants;

    public function __construct()
    {

    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity(City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title = null)
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location = null)
    {
        $this->location = $location;

        return $this;
    }

    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTime $dateTime = null)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude = null)
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude = null)
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getEstimatedParticipants()
    {
        return $this->estimatedParticipants;
    }

    public function setEstimatedParticipants($estimatedParticipants = null)
    {
        $this->estimatedParticipants = $estimatedParticipants;

        return $this;
    }
}
