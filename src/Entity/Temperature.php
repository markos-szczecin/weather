<?php


namespace App\Entity;


use App\Helpers\Unit;

class Temperature implements iConvertible
{
    /** @var float */
    private $value;
    /** @var int */
    private $unit;
    /** @var Temperature */
    private $init_state;

    public function __construct(float $value, int $unit)
    {
        $this->value = $value;
        $this->unit = Unit::validateUnit($unit);
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return round($this->value, 2);
    }

    /**
     * @param float $value
     *
     * @return Temperature
     */
    public function setValue(float $value): iConvertible
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getUnit(): int
    {
        return $this->unit;
    }

    /**
     * @param int $unit
     *
     * @return Temperature
     */
    public function setUnit(int $unit): iConvertible
    {
        $this->unit = Unit::validateUnit($unit);

        return $this;
    }

    public function setInitState(): iConvertible
    {
        $this->init_state = clone $this;

        return $this;
    }
}