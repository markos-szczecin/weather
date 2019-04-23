<?php


namespace App\Library;


use App\Entity\Weather;
use App\Helpers\Unit;

class WeatherResponse
{
    const OK_CODE = 1;
    const ERR_CODE = -1;

    const DEFAULT_ERR_MSG = 'Wystąpił błąd podczas pobierania danych. Spróbuj później lub skontaktuj sie z administratorem :{';

    public $code = self::OK_CODE;
    public $message = 'OK';
    public $data = [];

    public function __construct(Weather $weather = null, int $unit = Unit::METRIC, int $code = self::OK_CODE, string $message = 'OK')
    {
        $this->code = $code;
        $this->message = $message;
        if ($weather) {
            $this->data = (new WeatherExtractor($weather, $unit))->getData();
        }
    }
}