<?php
if ( PHP_SAPI !== 'cli') {
    echo 'Application is only on command line';
    exit;
}
$loader = require_once ('vendor/autoload.php');
$loader->add('GSLab\\', __DIR__.'/src/');


$apartmentService = new GSLab\Package\Apartment();
$apartmentService->setAreaService(new GSLab\Package\Area())
    ->setFloorTypeService(new GSLab\Package\FloorType());


$inputClass = new GSLab\Package\Robot();
$inputClass->setApartmentService($apartmentService)
    ->setRobotTimeService(new GSLab\Package\RobotTime())
    ->setRobotBatteryService(new GSLab\Package\RobotBattery())
    ->process();
