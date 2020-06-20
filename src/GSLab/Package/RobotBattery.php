<?php

namespace GSLab\Package;

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
        $this->printWarn('Ohh I got discharge.. Please wait till I get fully charged');
        $rechargeSecondIndicator = 0;

        while(self::FULL_TIME_RECHARGE > $rechargeSecondIndicator) {
            $rechargeSecondIndicator++;
            echo '.';
            sleep(1);
        }

        echo PHP_EOL;
        $this->printInfo('Yah I got charged.. Again I am starting to clean your apartment!!!');
    }
}