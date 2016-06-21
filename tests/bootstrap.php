<?php

if (@!include __DIR__ . '/../vendor/autoload.php') {
    echo 'Install Nette Tester using `composer update --dev`';
    exit(1);
}

include 'unit/TestPresenter.php';

define(TEMP_DIR, __DIR__ . '/tmp');
Tester\Helpers::purge(TEMP_DIR);

Tester\Environment::setup();
date_default_timezone_set('Europe/Prague');

function run(Tester\TestCase $testCase) {
    $testCase->run(isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : NULL);
}