<?php


namespace App\Helpers;


class Unit
{
    const METRIC = 1;
    const IMPERIAL = 2;

    /**
     * @param int $unit
     *
     * @return int
     */
    public static function validateUnit(int $unit)
    {
        if (!in_array($unit, [self::METRIC, self::IMPERIAL])) {
            $unit = self::METRIC;
        }

        return $unit;
    }
}