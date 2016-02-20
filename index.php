<?php
require __DIR__ . '/vendor/autoload.php';

$blueApron = new \BlueApron\Client();

var_dump($blueApron->getWeeklyMenu());