<?php

namespace GSLab\Package;

/**
 * FloorType class
 */
class FloorType extends Base
{
    public const TYPE_HARD = 'H';

    public const TYPE_CARPET = 'C';

    /**@var String */
    private $type;

    /**
     * Get the value of type
     *
     * @return string
     */
    public function getType(): string
    {
        if (null === $this->type) {
            $this->setType($this->readType());
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
        $this->type = $type;

        return $this;
    }

     /**
     * Read type
     *
     * @return string
     */
    public function readType(): string
    {
        $floorType = (string)readline(
            sprintf(
                'Please enter floor type [%s-Hard, %s-Carpet]',
                self::TYPE_HARD,
                self::TYPE_CARPET
            )
        );

        //Recursive call
        if (false === $this->isValidType($floorType)) {
            $floorType = $this->readType();
        }

        return $floorType;
    }

    /**
     * Validate the floor type
     *
     * @param string $floorType
     * @return bool
     */
    public function isValidType(string $floorType): bool
    {
        switch ($floorType) {
            case self::TYPE_HARD:
            case self::TYPE_CARPET:
                return true;

            default:
                $this->printError(
                    sprintf(
                        'Please enter CHAR %s or %s',
                        self::TYPE_HARD,
                        self::TYPE_CARPET
                    )
                );
                return false;
        }
    }
}