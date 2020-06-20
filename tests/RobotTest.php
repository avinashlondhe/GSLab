<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use GSLab\Package\RobotBattery;
use PHPUnit\Framework\MockObject\MockBuilder;

/**
 * RobotTest class
 */
final class RobotTest extends TestCase
{
    /**
     * Test valid clean
     *
     * @return void
     */
    public function testValidClean()
    {
        $area = 30;
        $timeToCLeanOneSquareMeter = 1;
        $robotServiceMock = $this->initRobotService($area);

        $this->assertSame(
            [($area*$timeToCLeanOneSquareMeter), 0],
            $robotServiceMock->clean($area, $timeToCLeanOneSquareMeter)
        );
    }

    /**
     * Test valid carpet floor with recharge
     *
     * @return void
     */
    public function testValidCarpetFloorWithRecharge()
    {
        $area = 60;
        $timeToCLeanOneSquareMeter = 2;

        $robotServiceMock = $this->initRobotService($area);
        $this->addRobotDischargedMethodMock($robotServiceMock, $timeToCLeanOneSquareMeter);

        $this->assertEquals(
            [($area*$timeToCLeanOneSquareMeter), 1],
            $robotServiceMock->clean($area, $timeToCLeanOneSquareMeter),
            'Something wrong with delta, Output did matched'
        );
    }


    /**
     * Init robot service
     *
     * NOTE: Strict return type can not be used because MOCK is dynamic class creation Ex. Mock_Robot_42961955
     * @param int $area
     * @return MockBuilder
     */
    private function initRobotService(int $area)
    {
        $robotServiceMock = $this->getMockBuilder('GSLab\Package\Robot')
            ->setMethods([
                'isApartmentCleaned',
                'isRobotDischarged',
                'printAndSleep',
                'printInfo'
            ])
            ->getMock();

        $robotServiceMock->expects($this->any())
            ->method('isApartmentCleaned')
            ->willReturnCallback(
                function () use (&$area) {
                    $area--;
                    return (0 >= $area);
                }
            );

        return $robotServiceMock;
    }

    /**
     * Add robot discharge method mock
     *
     * @param MockBuilder $robotServiceMock
     * @param int $timeToCLeanOneSquareMeter
     * @return MockBuilder
     */
    private function addRobotDischargedMethodMock($robotServiceMock, int $timeToCLeanOneSquareMeter)
    {
        $secondCount = 0;
        $batteryLife = (RobotBattery::BATTERY_LIEF/$timeToCLeanOneSquareMeter);

        $robotServiceMock->expects($this->any())
            ->method('isRobotDischarged')
            ->willReturnCallback(
                function () use (&$secondCount, $batteryLife) {
                    $secondCount ++;
                    return (0 === ($secondCount % $batteryLife));
                }
            );

        return $robotServiceMock;
    }

    /**
     * Test invalid carpet floor with recharge
     *
     * @return void
     */
    public function testInvalidCarpetFloorWithRecharge()
    {
        $area = 60;
        $timeToCLeanOneSquareMeter = 2;

        $robotServiceMock = $this->initRobotService($area);
        $this->addRobotDischargedMethodMock($robotServiceMock, $timeToCLeanOneSquareMeter);

        $this->assertNotEquals(
            [($area*$timeToCLeanOneSquareMeter), 3],
            $robotServiceMock->clean($area, $timeToCLeanOneSquareMeter)
        );
    }
}
