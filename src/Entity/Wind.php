<?php


namespace App\Entity;


use App\Helpers\Unit;

class Wind implements iConvertible
{
    /** @var float */
    private $value;
    /** @var float */
    private $degree;
    /** @var int */
    private $unit;
    /** @var Wind */
    private $init_state;

    public function __construct(float $speed, float $degree, int $unit)
    {
        $this->value = $speed;
        $this->degree = $degree;
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
     * @param float $speed
     *
     * @return Wind
     */
    public function setValue(float $speed): iConvertible
    {
        $this->value = $speed;

        return $this;
    }

    /**
     * @return float
     */
    public function getDegree(): float
    {
        return $this->degree;
    }

    /**
     * @param float $degree
     *
     * @return Wind
     */
    public function setDegree(float $degree): Wind
    {
        $this->degree = $degree;

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
     * @return Wind
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