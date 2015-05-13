<?php

namespace XChainCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tokenly\XChainClient\Client;


class AssetInfoCommand extends XChainCommand {

    protected $name        = 'x:asset-info';
    protected $description = 'Retrieves asset info from xchain';

    protected function configure() {
        parent::configure();

        $this->addArgument(
                'asset-name',
                InputArgument::REQUIRED,
                'Asset Name'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $asset_name = $input->getArgument('asset-name');

        // init the client
        $client = $this->getClient($input);

        $output->writeln("<comment>calling getAsset for $asset_name</comment>");
        $result = $client->getAsset($asset_name);
        $output->writeln("<info>Result\n".json_encode($result, 192)."</info>");
    }

}
