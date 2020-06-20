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
        'hard' => 1,
        'carpet' => 2,
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
            throw new InvalidArgumentException('Time setting is missing for floor type');
        }

        return (int)intdiv(
            self::BATTERY_LIEF,
            self::TIME_TO_CLEAN[$floorType]
        );
    }

    /**
     * Get time require to clean one square meter
     *
     * @param string $floorType
     * @return integer
     */
    public function getTimeRequireToCleanOneSqMeter(string $floorType): int
    {
        if (!isset(self::TIME_TO_CLEAN[$floorType])) {
            throw new InvalidArgumentException('Time setting is missing for floor type');
        }

        return (int)self::TIME_TO_CLEAN[$floorType];
    }
}