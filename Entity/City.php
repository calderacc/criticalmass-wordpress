<?php

namespace Caldera\CriticalmassWordpress\Entity;

class City
{
    /** @var string $name */
    protected $name;

    /** @var string $description */
    protected $description;

    /** @var string $description */
    protected $slug;

    /** @var float $latitude */
    protected $latitude;

    /** @var float $longitude */
    protected $longitude;

    public function __construct()
    {

    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name = null): City
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description = null): City
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug = null): City
    {
        $this->slug = $slug;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude = null): City
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude = null): City
    {
        $this->longitude = $longitude;

        return $this;
    }
}
