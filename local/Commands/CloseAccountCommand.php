<?php

namespace XChainCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tokenly\XChainClient\Client;

class CloseAccountCommand extends XChainCommand {

    protected $name        = 'x:close-account';
    protected $description = 'Close an account';

    protected function configure() {
        parent::configure();

        $this
            ->addArgument(
                'payment-address-uuid',
                InputArgument::REQUIRED,
                'Payment Address UUID'
            )
            ->addArgument(
                'source',
                InputArgument::REQUIRED,
                'Source account name'
            )
            ->addArgument(
                'destination',
                InputArgument::OPTIONAL,
                'Destination accoutn name',
                'default'
            )

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $payment_address_uuid = $input->getArgument('payment-address-uuid');
        $source               = $input->getArgument('source');
        $destination          = $input->getArgument('destination');

        // init the client
        $client = $this->getClient($input);

        $output->writeln("<comment>calling closeAccount($payment_address_uuid, $source, $destination)</comment>");
        $result = $client->closeAccount($payment_address_uuid, $source, $destination);
        $output->writeln("<info>Result\n".json_encode($result, 192)."</info>");
    }

}
