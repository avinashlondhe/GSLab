<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use GSLab\Package\Area;

final class AreaTest extends TestCase
{
    /**
     * Test invalid min limit
     *
     * @return void
     */
    public function testInvalidMinLimit()
    {
        $this->expectException(InvalidArgumentException::class);
        $area = new Area();

        $area->validate(4);
    }

    /**
     * Test invalid max limit
     *
     * @return void
     */
    public function testInvalidMaxLimit()
    {
        $this->expectException(InvalidArgumentException::class);
        $area = new Area();

        $area->validate(501);
    }

    /**
     * Valid area limit
     *
     * @return void
     */
    public function testValidLimit()
    {
        $area = new Area();

        $this->assertTrue($area->validate(45));
    }

    /**
     * Test get method when area is null by default
     *
     * @return void
     */
    public function testInvalidGetArea()
    {
        $this->expectException(InvalidArgumentException::class);
        $area = new Area();

        $area->getArea();
    }
}
