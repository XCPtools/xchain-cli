#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;
use XChainCLI\Commands\AssetInfoCommand;
use XChainCLI\Commands\CloseAccountCommand;
use XChainCLI\Commands\CreateMonitorCommand;
use XChainCLI\Commands\SendCommand;
use XChainCLI\Commands\TransferCommand;
use XChainCLI\Commands\UpdateMonitorCommand;

require __DIR__.'/vendor/autoload.php';

$app = new Application();
$app->add(new AssetInfoCommand());
$app->add(new CreateMonitorCommand());
$app->add(new UpdateMonitorCommand());
$app->add(new SendCommand());
$app->add(new CloseAccountCommand());
$app->add(new TransferCommand());
$app->run();
