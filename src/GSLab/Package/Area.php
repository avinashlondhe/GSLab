<?php

namespace GSLab\Package;

use InvalidArgumentException;

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
     * @throws InvalidArgumentException
     */
    public function getArea(): int
    {
        if (null === $this->area) {
            throw new InvalidArgumentException('Area is not available');
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
        $this->validate($area);

        $this->area = $area;

        return $this;
    }

     /**
     * Validate the area
     *
     * @param int $area
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(int $area): bool
    {
        if (self::MIN_AREA > $area || self::MAX_AREA < $area) {

            throw new InvalidArgumentException(
                sprintf(
                    'Invalid area, Please enter number from %d to %d',
                    self::MIN_AREA,
                    self::MAX_AREA
                )
            );
        }

        return true;
    }
}