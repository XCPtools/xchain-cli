<?php

namespace XChainCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tokenly\XChainClient\Client;


class AddressBalanceCommand extends XChainCommand {

    protected $name        = 'x:address-balance';
    protected $description = 'Retrieves address balances from xchain';

    protected function configure() {
        parent::configure();

        $this->addArgument(
                'address',
                InputArgument::REQUIRED,
                'Bitcoin Address'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $address = $input->getArgument('address');

        // init the client
        $client = $this->getClient($input);

        $output->writeln("<comment>calling getBalances for $address</comment>");
        $result = $client->getBalances($address);
        $output->writeln("<info>Result\n".json_encode($result, 192)."</info>");
    }

}
