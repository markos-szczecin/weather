<?php


namespace App\Library;


use App\Helpers\Unit;
use App\Entity\iConvertible;

abstract class Converter
{
    /** @var iConvertible  */
    protected $model;
    /** @var int  */
    protected $convert_to_unit;

    /**
     * Converter constructor.
     * @param iConvertible $model
     * @param int $convert_to_unit
     */
    public function __construct(iConvertible $model, int $convert_to_unit)
    {
        $this->model = $model;
        $this->convert_to_unit = $convert_to_unit;
        if ($model->getUnit() !== $convert_to_unit) {
            switch ($this->convert_to_unit) {
                case Unit::METRIC:
                    $this->convertToMetrics();
                    break;
                case Unit::IMPERIAL:
                    $this->convertToImperial();
                    break;
            }
        }
    }

    protected abstract function convertToMetrics();
    protected abstract function convertToImperial();
}