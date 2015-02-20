<?php

$loader = require __DIR__ . '/../vendor/autoload.php';

$front_controller = \FrontController\FrontController::getInstance();

$front_controller
    ->setLoader($loader)
    ->setRoutesPath(__DIR__ . '/app/config/routes.php')
    ->setNamespaces(
        array(
            'User\\' => __DIR__ . '/app/modules'
        )
    )
    ->init()
;