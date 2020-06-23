<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use GSLab\RoboticCleaner\RobotTime;

final class RobotTimeTest extends TestCase
{
    /**
     * Test invalid floor type
     *
     * @return void
     */
    public function testInvalidFloorType()
    {
        $this->expectException(InvalidArgumentException::class);
        $robotTimeService = new RobotTime();

        $this->assertFalse($robotTimeService->getTimeRequireToCleanOneSqMeter('abc'));
    }

    /**
     * Test robot is discharge
     *
     * @return void
     */
    public function testDischarged()
    {
        $robotTimeService = new RobotTime();

        $this->assertSame(2, $robotTimeService->getTimeRequireToCleanOneSqMeter('carpet'));
    }
}
