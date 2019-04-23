<?php


namespace App\Library;


use App\Entity\Weather;
use App\Helpers\Unit;

class HistoryDataGenerator
{
    private $history = [];

    /**
     * HistoryDataGenerator constructor.
     * @param array $weathers
     * @param int $unit
     */
    public function __construct(array $weathers,  int $unit = Unit::METRIC)
    {
        $weatherExctractor = new WeatherExtractor();
        foreach ($weathers as $weather) {
            $this->history[] = $weatherExctractor->setWeather($weather)->setUnit($unit)->getArrayData();
        }
    }

    public function getRows(): array
    {
        return $this->history;
    }
}