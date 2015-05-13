#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;
use XChainCLI\Commands\AssetInfoCommand;
use XChainCLI\Commands\CreateMonitorCommand;
use XChainCLI\Commands\UpdateMonitorCommand;

require __DIR__.'/vendor/autoload.php';

$app = new Application();
$app->add(new AssetInfoCommand());
$app->add(new CreateMonitorCommand());
$app->add(new UpdateMonitorCommand());
$app->run();
