<?php


namespace App\Library;


use App\Entity\Statistics;
use App\Entity\Temperature;
use App\Entity\Weather;
use App\Entity\Wind;
use App\Helpers\Unit;

class StatisticsCalculator
{
    /** @var Weather[]|array  */
    private $weathers = [];
    /** @var float  */
    private $temperature_sum = 0.00;
    /** @var float */
    private $lowest_temperature = INF;
    /** @var float */
    private $highest_temperature = -INF;
    private $average_temperature = 0.00;
    private $places_frequency = [];

    private $unit;
    /**
     * StatisticsCalculator constructor.
     * @param Weather[] $weathers
     */
    public function __construct(array $weathers, int $unit = Unit::METRIC)
    {
        $this->unit = Unit::validateUnit($unit);;
        $this->weathers = $weathers;
        foreach ($this->weathers as $weather) {
           $this->checkLowerTemperature($weather);
           $this->checkHigherTemperature($weather);
           $this->fillPlaceFrequency($weather);
           $this->temperature_sum += floatval($weather->getTemperature());
        }
        $this->calculateAverageTemperature();
    }

    /**
     * @param Weather $weather
     */
    private function checkLowerTemperature(Weather $weather)
    {
        $this->lowest_temperature = min($this->lowest_temperature, floatval($weather->getTemperature()));
    }

    /**
     * @param Weather $weather
     */
    private function checkHigherTemperature(Weather $weather)
    {
        $this->highest_temperature = max($this->highest_temperature, floatval($weather->getTemperature()));
    }

    private function calculateAverageTemperature()
    {
        $this->average_temperature = round($this->temperature_sum / count($this->weathers), 2);
    }

    /**
     * @param Weather $weather
     */
    private function fillPlaceFrequency(Weather $weather)
    {
        $place = trim($weather->getLocationName());
        if (isset($this->places_frequency[$place])) {
            $this->places_frequency[$place]++;
        } else {
            $this->places_frequency[$place] = 1;
        }

    }

    /**
     * @return array
     */
    private function getTheMostCommonPlace(): array
    {
        static $ret = [];

        if (!$ret) {
            $max = max($this->places_frequency);
            $ret = array_keys($this->places_frequency, $max);
        }

        return $ret;
    }

    /**
     * @return array
     */
    public function get(): Statistics
    {
        $this->highest_temperature = (new TemperatureConverter((new Temperature((float) $this->highest_temperature, Unit::METRIC)), $this->unit))->get()->getValue();
        $this->lowest_temperature = (new TemperatureConverter((new Temperature((float) $this->lowest_temperature, Unit::METRIC)), $this->unit))->get()->getValue();
        $this->average_temperature = (new TemperatureConverter((new Temperature((float) $this->average_temperature, Unit::METRIC)), $this->unit))->get()->getValue();

        return (new Statistics())
            ->setMaxTemperature($this->highest_temperature)
            ->setMinTemperature($this->lowest_temperature)
            ->setAverageTemperature($this->average_temperature)
            ->setCommonPlaces($this->getTheMostCommonPlace());
    }
}