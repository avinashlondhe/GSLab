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
    /**@var Area*/
    private $areaService;

    /**@var FloorType*/
    private $floorTypeService;

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
