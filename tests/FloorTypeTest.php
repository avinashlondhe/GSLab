<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use GSLab\RoboticCleaner\FloorType;

/**
 * FloorTypeTest class
 */
final class FloorTypeTest extends TestCase
{
    /**
     * Test validate invalid type
     *
     * @return void
     */
    public function testValidateInvalidType()
    {
        $this->expectException(InvalidArgumentException::class);
        $floorType = new FloorType();

        $floorType->validate('abc');
    }

    /**
     * Test set invalid type
     *
     * @return void
     */
    public function testSetInvalidType()
    {
        $this->expectException(InvalidArgumentException::class);
        $floorType = new FloorType();

        $floorType->validate('wooden');
    }

    /**
     * Test valid with carpet floor type
     *
     * @return void
     */
    public function testValidCarpetFloorType()
    {
        $floorType = new FloorType();

        $this->assertTrue($floorType->validate('carpet'));
    }

    /**
     * Test valid with hard floor type
     *
     * @return void
     */
    public function testValidHardFloorType()
    {
        $floorType = new FloorType();

        $this->assertTrue($floorType->validate('hard'));
    }

    /**
     * Test get method when area is null by default
     *
     * @return void
     */
    public function testInvalidGetFloorType()
    {
        $this->expectException(InvalidArgumentException::class);
        $floorType = new FloorType();

        $floorType->getType();
    }
}
