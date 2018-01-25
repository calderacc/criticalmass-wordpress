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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(City $city = null): Ride
    {
        $this->city = $city;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title = null): Ride
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description = null): Ride
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location = null): Ride
    {
        $this->location = $location;

        return $this;
    }

    public function getDateTime(): ?DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTime $dateTime = null): Ride
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude = null): Ride
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude = null): Ride
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getEstimatedParticipants(): ?int
    {
        return $this->estimatedParticipants;
    }

    public function setEstimatedParticipants(int $estimatedParticipants = null): Ride
    {
        $this->estimatedParticipants = $estimatedParticipants;

        return $this;
    }
}
