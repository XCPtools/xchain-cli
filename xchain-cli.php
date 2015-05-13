#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;
use XChainCLI\Commands\AssetInfoCommand;

require __DIR__.'/vendor/autoload.php';

$app = new Application();
$app->add(new AssetInfoCommand());
$app->run();
