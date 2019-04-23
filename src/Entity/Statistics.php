<?php


namespace App\Entity;


class Statistics
{
    private $max_temperature;
    private $min_temperature;
    private $average_temperature;
    private $common_places = [];

    const MAX_TEMPERATURE = 1;
    const MIN_TEMPERATURE = 2;
    const AVERAGE_TEMPERATURE = 3;
    const COMMON_PLACES = 4;

    /**
     * @return float
     */
    public function getMaxTemperature(): ?float
    {
        return $this->max_temperature;
    }

    /**
     * @param float $max_temperature
     *
     * @return Statistics
     */
    public function setMaxTemperature(float $max_temperature): self
    {
        $this->max_temperature = $max_temperature;

        return $this;
    }

    /**
     * @return float
     */
    public function getMinTemperature(): ?float
    {
        return $this->min_temperature;
    }

    /**
     * @param float $min_temperature
     *
     * @return Statistics
     */
    public function setMinTemperature(float $min_temperature): self
    {
        $this->min_temperature = $min_temperature;

        return $this;
    }

    /**
     * @return float
     */
    public function getAverageTemperature(): ?float
    {
        return $this->average_temperature;
    }

    /**
     * @param float $average_temperature
     *
     * @return Statistics
     */
    public function setAverageTemperature(float $average_temperature): self
    {
        $this->average_temperature = $average_temperature;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommonPlaces(): array
    {
        return $this->common_places;
    }

    /**
     * @param array $common_places
     *
     * @return Statistics
     */
    public function setCommonPlaces(array $common_places): self
    {
        $this->common_places = $common_places;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::AVERAGE_TEMPERATURE => $this->average_temperature,
            self::MIN_TEMPERATURE => $this->min_temperature,
            self::MAX_TEMPERATURE => $this->max_temperature,
            self::COMMON_PLACES => $this->common_places
        ];
    }
}