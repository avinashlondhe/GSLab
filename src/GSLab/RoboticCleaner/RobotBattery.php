<?php

namespace GSLab\RoboticCleaner;

/**
 * RobotBattery class
 */
class RobotBattery extends Base
{
    public const BATTERY_LIEF = 60;

    public const FULL_TIME_RECHARGE = 30;

    /**
     * Is robot discharged
     *
     * @param int $executedSeconds
     * @return bool
     */
    public function isDischarged(int $executedSeconds): bool
    {
        //First fail approach
        if (self::BATTERY_LIEF !== $executedSeconds) {
            return false;
        }

        $this->charge();

        return true;
    }

    /**
     * Charge robot/ Change battery
     *
     * @return void
     */
    public function charge()
    {
        echo PHP_EOL;
        $this->printWarn('Ohh I got discharge..');
        $rechargeSecondIndicator = 0;

        while(self::FULL_TIME_RECHARGE > $rechargeSecondIndicator) {
            $rechargeSecondIndicator++;
            echo sprintf(
                "\033[33m [Battery Level %0.2f%%] --  Please wait till I get fully charged\r \033[0m",
                $this->getRobotBatteryChargingLevel($rechargeSecondIndicator)
            );
            sleep(1);
        }

        echo PHP_EOL;
        $this->printInfo('Yah I got charged.. Again I am starting to clean your apartment!!!');
    }

    /**
     * Get robot battery level
     *
     * @param int $executedSeconds
     * @param bool $reverse
     * @return float
     */
    public function getRobotBatteryLevel(int $executedSeconds, bool $reverse = false): float
    {
        return $this->calculateBatteryPercentage(self::BATTERY_LIEF, $executedSeconds, $reverse);
    }

    /**
     * Get robot battery charging level
     *
     * @param int $executedSeconds
     * @param bool $reverse
     * @return float
     */
    public function getRobotBatteryChargingLevel(int $executedSeconds, bool $reverse = false): float
    {
        return $this->calculateBatteryPercentage(self::FULL_TIME_RECHARGE, $executedSeconds, $reverse);
    }

    /**
     * Calculate robot battery percentage
     *
     * @param int $executedSeconds
     * @param bool $reverse
     * @return float
     */
    private function calculateBatteryPercentage($total, $seconds, bool $reverse = false): float
    {
        $percentage =  (
            ( $seconds/ $total) * 100
        );

        if ($reverse) {
            $percentage = 100 - $percentage;
        }

        return $percentage;
    }
}