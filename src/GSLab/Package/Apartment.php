<?php

namespace GSLab\Package;

use GSLab\Package\Area as Area;
use GSLab\Package\FloorType as FloorType;
use InvalidArgumentException;

/**
 * Apartment class
 */
class Apartment extends Base
{
    const MIN_APARTMENT_COUNT = 1;

    const MAX_APARTMENT_COUNT = 5;

    /**@var int*/
    private $count;

    /**@var Area*/
    private $areaService;

    /**@var FloorType*/
    private $floorTypeService;

    /**
     * Get the value of count
     *
     * @return int
     */
    public function getCount(): int
    {
        if (null === $this->count) {
            $this->setCount($this->readCount());
        }

        return $this->count;
    }

    /**
     * Set the value of count
     *
     * @param int $count
     * @return self
     */
    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get the value of areaService
     *
     * @return Area
     * @throws InvalidArgumentException
     */
    public function getAreaService(): Area
    {
        if (!$this->areaService instanceof Area) {
            throw new InvalidArgumentException('Invalid Area Service');
        }

        return $this->areaService;
    }

    /**
     * Set the value of area service
     *
     * @param Area $areaService
     * @return self
     */
    public function setAreaService(Area $areaService): self
    {
        $this->areaService = $areaService;

        return $this;
    }

    /**
     * Get the value of floor type service
     *
     * @return FloorType
     * @throws InvalidArgumentException
     */
    public function getFloorTypeService(): FloorType
    {
        if (!$this->floorTypeService instanceof FloorType) {
            throw new InvalidArgumentException('Invalid Floor Type Service');
        }

        return $this->floorTypeService;
    }

    /**
     * Set the value of floor type service
     *
     * @param FloorType $floorTypeService
     * @return self
     */
    public function setFloorTypeService(FloorType $floorTypeService):self
    {
        $this->floorTypeService = $floorTypeService;

        return $this;
    }

    /**
     * Read the count
     *
     * @return int $apartmentCount
     */
    private function readCount(): int
    {
        $apartmentCount = (int) readline(
            sprintf(
                'How many apartments you would like clean? (Please enter only %d to %d)',
                self::MIN_APARTMENT_COUNT,
                self::MAX_APARTMENT_COUNT
            )
        );

        //Recursive call
        if (false === $this->isValidCount($apartmentCount)) {
            $apartmentCount = $this->readCount();
        }

        return $apartmentCount;
    }

    /**
     * Validate the count
     *
     * @param int $count
     * @return bool
     */
    private function isValidCount(int $count): bool
    {
        if (self::MIN_APARTMENT_COUNT > $count || self::MAX_APARTMENT_COUNT < $count) {
            $this->printError(
                sprintf(
                    'Please enter digit from %d to %d',
                    self::MIN_APARTMENT_COUNT,
                    self::MAX_APARTMENT_COUNT
                )
            );

            return false;
        }

        return true;
    }

    /**
     * Read properties
     *
     * @return void
     */
    public function readProperties()
    {
        $this->getAreaService()->getArea();
        $this->getFloorTypeService()->getType();
    }
}
