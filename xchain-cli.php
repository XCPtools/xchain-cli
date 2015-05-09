#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;
use XChainCLI\Commands\XChainCommand;

require __DIR__.'/vendor/autoload.php';

$app = new Application();
$app->add(new XChainCommand());
$app->run();
