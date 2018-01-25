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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name = null)
    {
        $this->name = $name;

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

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug = null)
    {
        $this->slug = $slug;

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
}
