<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\NamedNativeQuery;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeatherRepository")
 */
class Weather
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", options={"default": 0})
     */
    private $lng;

    /**
     * @ORM\Column(type="float", options={"default": 0})
     */
    private $lat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $temperature;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $wind_speed;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $wind_deg;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cloud;

    /**
     * @ORM\Column(type="string", length=255, options={"default": ""})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, options={"default": ""})
     */
    private $location_name;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $create_time;

    public function __construct()
    {
        $this->create_time = new DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return float|null
     */
    public function getLng(): ?float
    {
        return $this->lng;
    }

    /**
     * @param float $lng
     *
     * @return Weather
     */
    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     *
     * @return Weather
     */
    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getWindSpeed(): ?float
    {
        return $this->wind_speed;
    }

    /**
     * @param float $wind_speed
     *
     * @return Weather
     */
    public function setWindSpeed(float $wind_speed): self
    {
        $this->wind_speed = $wind_speed;

        return $this;
    }

    /**
     * @return float
     */
    public function getWindDeg(): ?float
    {
        return $this->wind_deg;
    }

    /**
     * @param mixed $wind_deg
     *
     * @return Weather
     */
    public function setWindDeg(float $wind_deg)
    {
        $this->wind_deg = $wind_deg;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    /**
     * @param string $temperature
     *
     * @return Weather
     */
    public function setTemperature(string $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getCloud(): ?float
    {
        return $this->cloud;
    }

    /**
     * @param float $cloud
     *
     * @return Weather
     */
    public function setCloud(float $cloud): self
    {
        $this->cloud = $cloud;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Weather
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocationName()
    {
        return $this->location_name;
    }

    /**
     * @param mixed $location_name
     * @return Weather
     */
    public function setLocationName($location_name)
    {
        $this->location_name = $location_name;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * @param DateTime $create_time
     *
     * @return Weather
     */
    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;

        return $this;
    }


}
