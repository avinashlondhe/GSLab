<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use GSLab\RoboticCleaner\RobotBattery;

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
        $robotBatteryMock = $this->getMockBuilder('GSLab\RoboticCleaner\RobotBattery')
            ->setMethods([
                'charge'
            ])
            ->getMock();

        $this->assertTrue($robotBatteryMock->isDischarged(60));
    }

    /**
     * Test valid robot battery level
     *
     * @return void
     */
    public function testValidBatteryLevel()
    {
        $robotBatteryService = new RobotBattery();

        $this->assertEquals(75.00, $robotBatteryService->getRobotBatteryLevel(15, true));
    }

    /**
     * Test valid robot battery charging
     *
     * @return void
     */
    public function testValidBatteryCharging()
    {
        $robotBatteryService = new RobotBattery();

        $this->assertEquals(50.00, $robotBatteryService->getRobotBatteryChargingLevel(15));
    }
}
