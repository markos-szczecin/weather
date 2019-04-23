<?php


namespace App\Library;


use App\Helpers\Unit;
use App\Entity\iConvertible;
use App\Entity\Temperature;

class TemperatureConverter extends Converter
{
    /**
     * TemperatureConverter constructor.
     * @param Temperature $temperature
     * @param int $convert_to_unit
     */
    public function __construct(Temperature $temperature, int $convert_to_unit)
    {
        parent::__construct($temperature, $convert_to_unit);
        $this->model->setInitState();

    }

    /**
     * @return TemperatureConverter
     */
    public final function convertToImperial(): self
    {
        if ($this->model->getUnit() === $this->convert_to_unit) {
            return $this;
        }
        $c_temp = $this->model->getValue();
        $f_temp = (9/5) * $c_temp + 32;

        $this->model
            ->setUnit(Unit::IMPERIAL)
            ->setValue($f_temp);

        return $this;
    }

    public final function convertToMetrics()
    {
        //TODO Jak będzie potrzeba implementacji to zaimplementować
    }

    /**
     * @return iConvertible|Temperature
     */
    public function get(): iConvertible
    {
        return $this->model;
    }
}