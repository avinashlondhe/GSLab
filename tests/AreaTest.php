<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use GSLab\Package\Area;

final class AreaTest extends TestCase
{
    public function testInvalidMinLimit()
    {
        $area = new Area();

        $this->assertFalse($area->isValidArea(4));
    }

    public function testInvalidMaxLimit()
    {
        $area = new Area();

        $this->assertFalse($area->isValidArea(501));
    }

    /**
     * Valid area limit
     */
    public function testValidLimit()
    {
        $area = new Area();

        $this->assertTrue($area->isValidArea(45));
    }

    /**
     * Recursive test
     *
     * @return void
     */
    public function testRecursiveCall()
    {
        $area = $this->createMock(Area::class);

        $area->method('isValidArea')
            ->with(3)
            ->willReturn(false);

        $area->method('readArea')
            ->willReturn(5);

        $area->method('isValidArea')
            ->with(5)
            ->willReturn(true);


        $this->assertEquals(5, $area->readArea());
    }
}
