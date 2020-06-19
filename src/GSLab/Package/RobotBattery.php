<?php

namespace GSLab\Package;

use InvalidArgumentException;

/**
 * RobotBattery class
 */
class RobotBattery extends Base
{
    public const BATTERY_LIEF = 60;

    public const FULL_TIME_RECHARGE = 30;

    /**@var int */
    private $maxOperationTime;

    /**
     * Get the value of maxOperationTime
     *
     * @return int
     * @throws InvalidArgumentException
     */
    public function getMaxOperationTime(): int
    {
        if (null === $this->maxOperationTime) {
            throw new InvalidArgumentException('Max operation time not set');
        }

        return $this->maxOperationTime;
    }

    /**
     * Set the value of maxOperationTime
     *
     * @param int $maxOperationTime
     * @return self
     */
    public function setMaxOperationTime(int $maxOperationTime): self
    {
        $this->maxOperationTime = $maxOperationTime;

        return $this;
    }

    /**
     * Is robot discharged
     *
     * @param int $executedSeconds
     * @return bool
     */
    public function isDischarged(int $executedSeconds): bool
    {
        //First fail approach
        if ($this->maxOperationTime !== $executedSeconds) {
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
        $this->printWarn('Ohh I got discharge.. Please wait till I get fully charged');
        $rechargeSecondIndicator = 0;

        while(self::FULL_TIME_RECHARGE >= $rechargeSecondIndicator) {
            $rechargeSecondIndicator++;
            echo '.';
            sleep(1);
        }

        $this->printInfo('Yah I got charged.. Again I am starting to clean your apartment!!!');
    }
}