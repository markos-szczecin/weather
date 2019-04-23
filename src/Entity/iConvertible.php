<?php


namespace App\Entity;


interface iConvertible
{
    public function getUnit();
    public function getValue();
    public function setUnit(int $unit) : iConvertible;
    public function setValue(float $value) : iConvertible;
    public function setInitState(): iConvertible;
}