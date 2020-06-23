<?php
if ( PHP_SAPI !== 'cli') {
    echo 'Application is only on command line';
    exit;
}

$arguments = getopt(
    'f:a:',
    [
        "floor:",
        "area:"
    ]
);

$loader = require_once ('vendor/autoload.php');
$loader->add('GSLab\\', __DIR__.'/src/');

try {
    //Isset not required, we need value greater than zero
    if (empty($arguments['floor']) && empty($arguments['f'])) {
        throw new InvalidArgumentException('Floor type not found');
    }
    if (empty($arguments['area']) && empty($arguments['a'])) {
        throw new InvalidArgumentException('Area not found');
    }

    $arguments['floor'] = (isset($arguments['floor']) ? $arguments['floor'] : $arguments['f']);
    $arguments['area'] = (isset($arguments['area']) ? $arguments['area'] : $arguments['a']);

    $floorTypeService = new GSLab\RoboticCleaner\FloorType();
    $floorTypeService->setType($arguments['floor']);

    $areaService = new GSLab\RoboticCleaner\Area();
    $areaService->setArea($arguments['area']);

    $apartmentService = new GSLab\RoboticCleaner\Apartment();
    $apartmentService->setAreaService($areaService)
        ->setFloorTypeService($floorTypeService);

    $robotClass = new GSLab\RoboticCleaner\Robot();
    $robotClass->setApartmentService($apartmentService)
        ->setRobotTimeService(new GSLab\RoboticCleaner\RobotTime())
        ->setRobotBatteryService(new GSLab\RoboticCleaner\RobotBattery())
        ->process();

} catch (Exception $ex) {
    echo "\033[31m {$ex->getMessage()} \033[0m" . PHP_EOL;
}