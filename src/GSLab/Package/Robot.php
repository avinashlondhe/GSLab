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

    public function restServices()
    {
        $this->getApartmentService()->setAreaService(new Area())
            ->setFloorTypeService(new FloorType());
    }

    /**
     * Process the request
     *
     * @return void
     */
    public function process()
    {
        $apartmentCount = $this->getApartmentService()->getCount();

        while($apartmentCount > 0) {
            $apartmentCount--;
            $this->getApartmentService()->readProperties();
            $this->processRobot();
            $this->restServices();
        }
    }

    /**
     * Process robot
     *
     * @return void
     */
    public function processRobot()
    {
        $floorType =  $this->getApartmentService()->getFloorTypeService()->getType();
        //Set max operation time
        $this->getRobotBatteryService()->setMaxOperationTime(
            $this->getRobotTimeService()->getMaxOperationTime($floorType)
        );

        $time = $this->getRobotTimeService()->getTimeRequireToCleanPerSqMeter($floorType);

        //Max needs to be clean
        $maxAreaToClean = $this->getApartmentService()->getAreaService()->getArea();

        $this->printInfo('Hello, I am starting to clean your apartment!!');

        $secondIndicator = 0;
        $robotChargeCount = 0;
        $robotActiveTime = 0;

        while ($maxAreaToClean > 0) {
            $maxAreaToClean--;
            $secondIndicator += $time;
            sleep($time);
            echo '.';

            if ($this->isApartmentCleaned($maxAreaToClean)) {
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

        $this->printInfo(sprintf('Robot active time %d seconds', $robotActiveTime));
        $this->printInfo(sprintf('Robot got charged %d times', $robotChargeCount));
        $this->printSuccess('Your apartment has been cleaned successfully.....');
    }

    /**
     * Is apartment cleaned
     *
     * @param int $maxAreaToClean
     * @return bool
     */
    public function isApartmentCleaned(int $maxAreaToClean): bool
    {
        return (0 >= $maxAreaToClean);
    }
}