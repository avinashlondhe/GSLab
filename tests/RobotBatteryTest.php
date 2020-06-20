<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use GSLab\Package\RobotBattery;

final class RobotBatteryTest extends TestCase
{
    /**
     * Test robot is not discharge
     *
     * @return void
     */
    public function testNotDischarged()
    {
        $robotBatteryService = new RobotBattery();

        $this->assertFalse($robotBatteryService->isDischarged(30));
    }

    /**
     * Test robot is discharge
     *
     * @return void
     */
    public function testDischarged()
    {
        $robotBatteryMock = $this->getMockBuilder('GSLab\Package\RobotBattery')
            ->setMethods([
                'charge'
            ])
            ->getMock();

        $this->assertTrue($robotBatteryMock->isDischarged(60));
    }
}
