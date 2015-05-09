<?php

namespace XChainCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tokenly\XChainClient\Client;


class XChainCommand extends Command {

    protected function configure() {
        $this
            ->setName('xchain')
            ->setDescription('Retrieves info from xchain')

            ->addArgument(
                'xchain-url',
                InputArgument::REQUIRED,
                'XChain Client URL'
            )

            ->addArgument(
                'xchain-api-token',
                InputArgument::REQUIRED,
                'An xchain API token'
            )

            ->addArgument(
                'xchain-api-secret-key',
                InputArgument::REQUIRED,
                'An xchain API secret key'
            )

            ->addArgument(
                'method',
                InputArgument::REQUIRED,
                'The XChain Client method to call (asset)'
            )


            ->addOption(
                'asset',
                'a',
                InputOption::VALUE_OPTIONAL,
                'asset name'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $asset_name = $input->getOption('asset');
        $method = $input->getArgument('method');

        $xchain_url = $input->getArgument('xchain-url');
        $api_token = $input->getArgument('xchain-api-token');
        $api_secret_key = $input->getArgument('xchain-api-secret-key');

        // init the client
        $client = new Client($xchain_url, $api_token, $api_secret_key);


        switch ($method) {
            case 'asset':
                if (!$asset_name) { throw new Exception("Asset name not found", 1); }
                $output->writeln("<comment>calilng $method $asset_name</comment>");
                $result = $client->getAsset($asset_name);
                $output->writeln("<info>Result\n".json_encode($result, 192)."</info>");
                break;
            
            default:
                break;
        }

    }

}
