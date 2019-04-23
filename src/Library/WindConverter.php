<?php


namespace App\Library;


use App\Helpers\Unit;
use App\Entity\iConvertible;
use App\Entity\Temperature;
use App\Entity\Wind;

class WindConverter extends Converter
{
    /** 1 mmeters/s = 2.23693629 miles/h */
    const MILE_PER_HOUR = 2.23693629;

    public function __construct(Wind $wind, int $convert_to_unit)
    {
        parent::__construct($wind, $convert_to_unit);
        $this->model->setInitState();
    }

    /**
     * @return WindConverter
     */
    public final function convertToImperial(): self
    {
        if ($this->model->getUnit() === $this->convert_to_unit) {
            return $this;
        }
        $meter_speed = $this->model->getValue();
        $mile_speed = $meter_speed * self::MILE_PER_HOUR;
        $this->model
            ->setValue($mile_speed)
            ->setUnit(Unit::IMPERIAL);

        return $this;
    }

    public final function convertToMetrics()
    {
        //TODO Jak będzie potrzeba implementacji to zaimplementować
    }

    /**
     * @return iConvertible|Wind
     */
    public function get(): iConvertible
    {
        return $this->model;
    }
}