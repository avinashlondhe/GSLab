<?php

namespace GSLab\RoboticCleaner;

use GSLab\RoboticCleaner\Apartment as Apartment;
use GSLab\RoboticCleaner\RobotTime as RobotTime;
use GSLab\RoboticCleaner\RobotBattery as RobotBattery;
use InvalidArgumentException;

/**
 * Robot class
 */
class Robot extends Base
{

    /**@var Apartment */
    private $apartmentService;

    /**@var RobotTime */
    private $robotTimeService;

    /**@var RobotBattery */
    private $robotBatteryService;

    /**
     * Get the value of apartmentService
     *
     * @return Apartment
     * @throws InvalidArgumentException
     */
    public function getApartmentService(): Apartment
    {
        if (!$this->apartmentService instanceof Apartment) {
            throw new InvalidArgumentException('Invalid Apartment service');
        }

        return $this->apartmentService;
    }

    /**
     * Set the value of apartmentService
     *
     * @param Apartment $apartmentService
     * @return self
     */
    public function setApartmentService(Apartment $apartmentService): self
    {
        $this->apartmentService = $apartmentService;

        return $this;
    }

    /**
     * Get the value of robot time service
     *
     * @return RobotTime
     * @throws InvalidArgumentException
     */
    public function getRobotTimeService(): RobotTime
    {
        if (null === $this->robotTimeService) {
            throw new InvalidArgumentException('Invalid Robot Time service');
        }

        return $this->robotTimeService;
    }

    /**
     * Set the value of robot time service
     *
     * @param RobotTime $robotTimeService
     * @return self
     */
    public function setRobotTimeService(RobotTime $robotTimeService): self
    {
        $this->robotTimeService = $robotTimeService;

        return $this;
    }

    /**
     * Get the value of robot Battery service
     *
     * @return RobotBattery
     * @throws InvalidArgumentException
     */
    public function getRobotBatteryService(): RobotBattery
    {
        if (null === $this->robotBatteryService) {
            throw new InvalidArgumentException('Invalid Robot Battery service');
        }

        return $this->robotBatteryService;
    }

    /**
     * Set the value of robot battery service
     *
     * @param RobotBattery $robotBatteryService
     * @return self
     */
    public function setRobotBatteryService(RobotBattery $robotBatteryService): self
    {
        $this->robotBatteryService = $robotBatteryService;

        return $this;
    }

    /**
     * Process the request
     *
     * @return void
     */
    public function process()
    {
        $floorType = $this->getFloorType();
        $timeToCLeanOneSquareMeter = $this->getTimeRequireToCleanOneSqMeter($floorType);

        //Max needs to be clean
        $maxAreaToClean = $this->getAreaRequiredToClean();

        [$robotActiveTime, $robotChargeCount] = $this->clean($maxAreaToClean, $timeToCLeanOneSquareMeter);

        $this->printSuccessMessage($robotActiveTime, $robotChargeCount);
    }

    /**
     * Cleaning process
     *
     * @param int $maxAreaToClean
     * @param int $timeToCLeanOneSquareMeter
     * @return array
     */
    public function clean(int $maxAreaToClean, int $timeToCLeanOneSquareMeter): array
    {
        $secondIndicator = 0;
        $robotChargeCount = 0;
        $robotActiveTime = 0;

        $this->printInfo('Hello, I am starting to clean your apartment!!');

        $areaCleaned = 0;
        while (0 <= $maxAreaToClean) {
            $areaCleaned++;
            $maxAreaToClean--;
            $secondIndicator += $timeToCLeanOneSquareMeter;

            $this->printAndSleep($timeToCLeanOneSquareMeter, $areaCleaned, $secondIndicator);

            if ($this->isApartmentCleaned($maxAreaToClean)) {
                break;
            }

            if ($this->isRobotDischarged($secondIndicator)) {
                $robotActiveTime += $secondIndicator;

                //Reset second timer
                $secondIndicator = 0;
                $robotChargeCount++;
            }
        }

        $robotActiveTime += $secondIndicator;

        return [$robotActiveTime, $robotChargeCount];
    }

    /**
     * Sleep and print
     *
     * @param int $timeToCLeanOneSquareMeter
     * @return void
     */
    public function printAndSleep(int $timeToCLeanOneSquareMeter, $areaCleaned, $secondIndicator): void
    {
        echo sprintf(
            "\033[32m [Battery Level %0.2f%%] -- Area cleaned [%s] square meter \r \033[0m",
            $this->getRobotBatteryService()->getRobotBatteryLevel($secondIndicator, true),
            $areaCleaned
        );
        sleep($timeToCLeanOneSquareMeter);
    }

    /**
     * Check is robot discharged
     *
     * @param int $secondIndicator
     * @return bool
     */
    public function isRobotDischarged(int $secondIndicator): bool
    {
        return $this->getRobotBatteryService()->isDischarged($secondIndicator);
    }

    /**
     * Check apartment is cleaned
     *
     * @param int $maxAreaToClean
     * @return bool
     */
    public function isApartmentCleaned(int $maxAreaToClean): bool
    {
        return $this->getApartmentService()->isApartmentCleaned($maxAreaToClean);
    }

    /**
     * Print Success message
     *
     * @param integer $robotActiveTime
     * @param integer $robotChargeCount
     * @return void
     */
    public function printSuccessMessage(int $robotActiveTime, int $robotChargeCount): void
    {
        echo PHP_EOL;
        $this->printInfo(sprintf('Robot active time %d seconds', $robotActiveTime));
        $this->printInfo(sprintf('Robot got charged %d time(s)', $robotChargeCount));
        $this->printSuccess('Your apartment has been cleaned successfully.....');
    }

    /**
     * Get floor type
     *
     * @return string
     */
    private function getFloorType(): string
    {
        return $this->getApartmentService()->getFloorTypeService()->getType();
    }

    /**
     * Get time required to clean one square meter
     *
     * @param string $floorType
     * @return int
     */
    public function getTimeRequireToCleanOneSqMeter(string $floorType): int
    {
        return $this->getRobotTimeService()->getTimeRequireToCleanOneSqMeter($floorType);
    }

    /**
     * Get area required to clean
     *
     * @return int
     */
    public function getAreaRequiredToClean(): int
    {
        return $this->getApartmentService()->getAreaService()->getArea();
    }
}
