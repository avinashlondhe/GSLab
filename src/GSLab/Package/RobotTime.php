<?php

namespace GSLab\Package;

use GSLab\Package\RobotBattery;
use InvalidArgumentException;

/**
 * Apartment class
 */
class RobotTime extends Base
{
    public const TIME_TO_CLEAN = [
        'hard' => 1,
        'carpet' => 2,
    ];

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