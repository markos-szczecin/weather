<?php


namespace App\Library;


use App\Entity\Weather;

class OpenWeatherApi
{
    const APP_ID = '';
    const API_URL = 'http://api.openweathermap.org/data/2.5/weather?lat=%F&lon=%F&APPID=%s&units=metric';

    private $lat;
    private $lng;

    public function __construct(float $lat, float $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    /**
     * @return Weather
     * @throws \Exception
     */
    private function call()
    {
        return $this->createWeatherModel(file_get_contents(sprintf(self::API_URL, $this->lat, $this->lng, self::APP_ID)));

    }

    /**
     * @param string $weather_data
     * @return Weather
     * @throws \Exception
     */
    private function createWeatherModel(string $weather_data)
    {
        $data = json_decode($weather_data, true);
        if (!isset($data['cod']) || intval($data['cod']) !== 200) {
            throw new \Exception($data['message'] ?? 'Unknown error, please try again later');
        }

        $description = function (array $data) {
            $ret = [];
            foreach ($data['weather'] as $desc) {
                $ret[] = $desc['description'];
            }

            return implode('. ', $ret);
        };

        return (new Weather())
            ->setLat((float) $data['coord']['lat'])
            ->setLng((float) $data['coord']['lon'])
            ->setTemperature((string) $data['main']['temp'])
            ->setWindSpeed((float) $data['wind']['speed'])
            ->setWindDeg((float) $data['wind']['deg'])
            ->setCloud((float) $data['clouds']['all'])
            ->setDescription((string) $description($data))
            ->setLocationName((string) $data['name']);
    }

    /**
     * @return Weather
     * @throws \Exception
     */
    public function getWeather()
    {
        return $this->call();
    }
}
