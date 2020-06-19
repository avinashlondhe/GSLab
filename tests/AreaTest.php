<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use GSLab\Package\Area;

final class AreaTest extends TestCase
{
    public function testInvalidMinLimit()
    {
        $area = $this->createMock(Area::class);
        $area->method('printError');

        $this->assertFalse($area->isValidArea(4));
    }

    public function testInvalidMaxLimit()
    {
        $area = $this->createMock(Area::class);
        $area->method('printError');

        $this->assertFalse($area->isValidArea(501));
    }

    public function testValidLimit()
    {
        $area = $this->createMock(Area::class);
        $area->method('printError');

        $this->assertFalse($area->isValidArea(45));
    }
}
