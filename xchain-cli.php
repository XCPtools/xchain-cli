#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;
use XChainCLI\Commands\AddressBalanceCommand;
use XChainCLI\Commands\AssetInfoCommand;
use XChainCLI\Commands\CheckPrimedUTXOs;
use XChainCLI\Commands\CloseAccountCommand;
use XChainCLI\Commands\CleanupUTXOs;
use XChainCLI\Commands\CreateMonitorCommand;
use XChainCLI\Commands\EstimateCommand;
use XChainCLI\Commands\PrimeUTXOs;
use XChainCLI\Commands\SendCommand;
use XChainCLI\Commands\TransferCommand;
use XChainCLI\Commands\UpdateMonitorCommand;

require __DIR__.'/vendor/autoload.php';

$app = new Application();
$app->add(new AddressBalanceCommand());
$app->add(new AssetInfoCommand());
$app->add(new CreateMonitorCommand());
$app->add(new UpdateMonitorCommand());
$app->add(new SendCommand());
$app->add(new CloseAccountCommand());
$app->add(new TransferCommand());
$app->add(new CheckPrimedUTXOs());
$app->add(new PrimeUTXOs());
$app->add(new EstimateCommand());
$app->add(new CleanupUTXOs());

try {
    $app->run();
} catch (Exception $e) {
    echo "ERROR: ".$e->getMessage()."\n";
    echo $e->getTraceAsString()."\n";
}
