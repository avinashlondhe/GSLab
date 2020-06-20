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

    $floorTypeService = new GSLab\Package\FloorType();
    $floorTypeService->setType($arguments['floor']);

    $areaService = new GSLab\Package\Area();
    $areaService->setArea($arguments['area']);

    $apartmentService = new GSLab\Package\Apartment();
    $apartmentService->setAreaService($areaService)
        ->setFloorTypeService($floorTypeService);

    $robotClass = new GSLab\Package\Robot();
    $robotClass->setApartmentService($apartmentService)
        ->setRobotTimeService(new GSLab\Package\RobotTime())
        ->setRobotBatteryService(new GSLab\Package\RobotBattery())
        ->process();

} catch (Exception $ex) {
    echo "\033[31m {$ex->getMessage()} \033[0m" . PHP_EOL;
}