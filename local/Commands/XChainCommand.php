<?php

namespace XChainCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tokenly\XChainClient\Client;


class XChainCommand extends Command {

    protected $name        = null;
    protected $description = null;

    protected function configure() {
        $this
            ->setName($this->name)
            ->setDescription($this->description)

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
        ;
    }

    protected function getClient(InputInterface $input) {
        $xchain_url = $input->getArgument('xchain-url');
        $api_token = $input->getArgument('xchain-api-token');
        $api_secret_key = $input->getArgument('xchain-api-secret-key');

        // init the client
        $client = new Client($xchain_url, $api_token, $api_secret_key);

        return $client;
    }

}
