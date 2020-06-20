<?php

namespace GSLab\Package;

use GSLab\Package\Apartment as Apartment;
use GSLab\Package\RobotTime as RobotTime;
use GSLab\Package\RobotBattery as RobotBattery;
use GSLab\Package\Area as Area;
use GSLab\Package\FloorType as FloorType;
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
        $floorType =  $this->getApartmentService()->getFloorTypeService()->getType();
        //Set max operation time
        $this->getRobotBatteryService()->setMaxOperationTime(
            $this->getRobotTimeService()->getMaxOperationTime($floorType)
        );

        $time = $this->getRobotTimeService()->getTimeRequireToCleanOneSqMeter($floorType);

        //Max needs to be clean
        $maxAreaToClean = $this->getApartmentService()->getAreaService()->getArea();

        $secondIndicator = 0;
        $robotChargeCount = 0;
        $robotActiveTime = 0;

        $this->printInfo('Hello, I am starting to clean your apartment!!');

        while ($maxAreaToClean > 0) {
            $maxAreaToClean--;
            $secondIndicator += $time;
            sleep($time);
            echo '.';

            if ($this->getApartmentService()->isApartmentCleaned($maxAreaToClean)) {
                break;
            }

            if ($this->getRobotBatteryService()->isDischarged($secondIndicator)) {
                $robotActiveTime += $secondIndicator;

                //Reset second timer
                $secondIndicator = 0;
                $robotChargeCount++;
            }
        }


        $robotActiveTime += $secondIndicator;
        echo PHP_EOL;
        $this->printInfo(sprintf('Robot active time %d seconds', $robotActiveTime));
        $this->printInfo(sprintf('Robot got charged %d times', $robotChargeCount));
        $this->printSuccess('Your apartment has been cleaned successfully.....');
    }
}