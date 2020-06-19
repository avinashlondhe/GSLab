<?php

namespace GSLab\Package;

use InvalidArgumentException;

/**
 * Apartment class
 */
class RobotTime extends Base
{
    public const BATTERY_LIEF = 60;

    public const FULL_TIME_RECHARGE = 30;

    public const TIME_TO_CLEAN = [
        'H' => 1,
        'C' => 2,
    ];

    /**
     * Get Max operation time
     *
     * @param string $floorType
     * @return integer
     */
    public function getMaxOperationTime(string $floorType): int
    {
        if (!isset(self::TIME_TO_CLEAN[$floorType])) {
            throw new InvalidArgumentException('Invalid floor type found');
        }

        return (int)intdiv(
            self::BATTERY_LIEF,
            self::TIME_TO_CLEAN[$floorType]
        );
    }

    public function getTimeRequireToCleanPerSqMeter(string $floorType): int
    {
        if (!isset(self::TIME_TO_CLEAN[$floorType])) {
            throw new InvalidArgumentException('Invalid floor type found');
        }

        return (int)self::TIME_TO_CLEAN[$floorType];
    }
}