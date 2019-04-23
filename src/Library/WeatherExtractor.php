<?php


namespace App\Library;


use App\Helpers\Unit;
use App\Entity\Weather;
use App\Entity\Temperature;
use App\Entity\Wind;

class WeatherExtractor
{
    /** @var int  */
    private $unit;
    /** @var Weather */
    private $weather;

    public function setWeather(Weather $weather): self
    {
        $this->weather = $weather;

        return $this;
    }

    public function setUnit(int $unit): self
    {
        $this->unit = Unit::validateUnit($unit);

        return $this;
    }

    /**
     * WeatherExtractor constructor.
     * @param Weather $weather
     * @param int $unit
     */
    public function __construct(Weather $weather = null, int $unit = Unit::METRIC)
    {
        $this->unit = Unit::validateUnit($unit);
        $this->weather = $weather;
    }

    /**
     * @return string
     */
    private function getTemperature(): string
    {
        $temperature = new Temperature($this->weather->getTemperature(), Unit::METRIC);
        if ($this->unit !== Unit::METRIC) {
            //Dane w bazie zawsze są w unit metric
            $temperature = (new TemperatureConverter($temperature, $this->unit))->convertToImperial()->get();
        }

        return $temperature->getValue() . ' ' . $this->getUnitTxt($temperature->getUnit(), Temperature::class);
    }

    /**
     * @return string
     */
    private function getWind(): string
    {
        $wind = new Wind($this->weather->getWindSpeed(), $this->weather->getWindDeg(), Unit::METRIC);
        if ($this->unit !== Unit::METRIC) {
            //Dane w bazie zawsze są w unit metric
            $wind = (new WindConverter($wind, $this->unit))->convertToImperial()->get();
        }

        return $wind->getValue() . ' ' . $this->getUnitTxt($wind->getUnit(), Wind::class) . ' | ' . $this->getWindCardinals($wind->getDegree());
    }

    private function getWindCardinals($deg)
    {
        $cardinalDirections = array(
            'N' => array(348.75, 360),
            'N2' => array(0, 11.25),
            'NNE' => array(11.25, 33.75),
            'NE' => array(33.75, 56.25),
            'ENE' => array(56.25, 78.75),
            'E' => array(78.75, 101.25),
            'ESE' => array(101.25, 123.75),
            'SE' => array(123.75, 146.25),
            'SSE' => array(146.25, 168.75),
            'S' => array(168.75, 191.25),
            'SSW' => array(191.25, 213.75),
            'SW' => array(213.75, 236.25),
            'WSW' => array(236.25, 258.75),
            'W' => array(258.75, 281.25),
            'WNW' => array(281.25, 303.75),
            'NW' => array(303.75, 326.25),
            'NNW' => array(326.25, 348.75)
        );
        $cardinal = '';
        foreach ($cardinalDirections as $dir => $angles) {
            if ($deg >= $angles[0] && $deg < $angles[1]) {
                $cardinal = str_replace("2", "", $dir);
            }
        }
        return $cardinal;
    }

    /**
     * @param int $unit
     * @param string $context
     *
     * @return string
     */
    private function getUnitTxt(int $unit, string $context)
    {
        switch ($context) {
            case Wind::class:
                return $this->getWindUnitTxt($unit);
            case Temperature::class:
                return $this->getTemperatureTxt($unit);
            default:
                return '';
        }
    }

    /**
     * @param int $unit
     *
     * @return string
     */
    private function getTemperatureTxt(int $unit)
    {
        switch ($unit) {
            case Unit::IMPERIAL:
                return '°F';
            case Unit::METRIC:
                return '°C';
            default:
                return '';
        }
    }

    /**
     * @param int $unit
     *
     * @return string
     */
    private function getWindUnitTxt(int $unit)
    {
        switch ($unit) {
            case Unit::IMPERIAL:
                return 'miles/hour';
            case Unit::METRIC:
                return 'meters/sec';
            default:
                return '';
        }
    }
    /**
     * @return string
     */
    public function getData(): string
    {
        return (string) json_encode($this->getArrayData());
    }

    public function getArrayData(): array
    {
        return [
            'lat' => $this->weather->getLat(),
            'lng' => $this->weather->getLng(),
            'wind' => ($this->getWind()),
            'temperature' => $this->getTemperature(),
            'cloud' => $this->weather->getCloud() . '%',
            'description' => ($this->weather->getDescription()),
            'location_name' => ($this->weather->getLocationName()),
            'date_time' => date('Y-m-d H:i:s', $this->weather->getCreateTime()->getTimestamp()),
            'id' => $this->weather->getId(),
            'location' => $this->weather->getLocationName()
        ];
    }
}