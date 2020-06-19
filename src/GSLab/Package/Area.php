<?php

namespace GSLab\Package;

/**
 * Area class
 */
class Area extends Base
{
    public const MIN_AREA = 5;

    public const MAX_AREA = 500;

    /**@var int*/
    private $area;

    /**
     * Get the value of area
     *
     * @return int
     */
    public function getArea(): int
    {
        if (null === $this->area) {
            $this->setArea($this->readArea());
        }

        return $this->area;
    }

    /**
     * Set the value of area
     *
     * @param int $area
     * @return self
     */
    public function setArea(int $area): self
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Read area
     *
     * @return int
     */
    public function readArea(): int
    {
        $apartmentArea = (int)readline(
            sprintf('Please enter the area in square meter (Allowed from %d to %d)', self::MIN_AREA, self::MAX_AREA)
        );

        //Recursive call
        if (false === $this->isValidArea($apartmentArea)) {
            $apartmentArea = $this->readArea();
        }

        return $apartmentArea;
    }

    /**
     * Validate the area
     *
     * @param int $count
     * @return bool
     */
    public function isValidArea(int $count): bool
    {
        if (self::MIN_AREA > $count || self::MAX_AREA < $count) {
            $this->printError(
                sprintf(
                    'Please enter number from %d to %d',
                    self::MIN_AREA,
                    self::MAX_AREA
                )
            );

            return false;
        }

        return true;
    }
}