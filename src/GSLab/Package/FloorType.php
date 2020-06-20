<?php

namespace GSLab\Package;

use InvalidArgumentException;

/**
 * FloorType class
 */
class FloorType extends Base
{
    public const TYPE_HARD = 'hard';

    public const TYPE_CARPET = 'carpet';

    /**@var String */
    private $type;

    /**
     * Get the value of type
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function getType(): string
    {
        if (null === $this->type) {
            throw new InvalidArgumentException('Floor type is not available');
        }

        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->validate($type);
        $this->type = $type;

        return $this;
    }

    /**
     * Validate the floor type
     *
     * @param string $floorType
     * @return bool
     */
    public function validate(string $floorType): bool
    {
        switch ($floorType) {
            case self::TYPE_HARD:
            case self::TYPE_CARPET:
                return true;

            default:
                throw new InvalidArgumentException(
                    sprintf(
                        'Please enter [%s or %s]',
                        self::TYPE_HARD,
                        self::TYPE_CARPET
                    )
                );
        }
    }
}