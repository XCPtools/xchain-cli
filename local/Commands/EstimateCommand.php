<?php

namespace XChainCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tokenly\XChainClient\Client;

class EstimateCommand extends XChainCommand {

    protected $name        = 'x:estimate';
    protected $description = 'Sends from a payment address';

    protected function configure() {
        parent::configure();

        $this
            ->addArgument(
                'payment-address-id',
                InputArgument::REQUIRED,
                'Payment UUID'
            )
            ->addArgument(
                'destination',
                InputArgument::REQUIRED,
                'Destination'
            )
            ->addArgument(
                'quantity',
                InputArgument::REQUIRED,
                'Quantity'
            )
            ->addArgument(
                'asset',
                InputArgument::REQUIRED,
                'Asset'
            )
            ->addOption(
                'account', 'a',
                InputOption::VALUE_OPTIONAL,
                'Account to send from',
                'default'
            )
            ->addOption(
                'priority', 'p',
                InputOption::VALUE_OPTIONAL,
                'Priority',
                'med'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $payment_address_id = $input->getArgument('payment-address-id');
        $destination        = $input->getArgument('destination');
        $quantity           = $input->getArgument('quantity');
        $asset              = $input->getArgument('asset');
        $account            = $input->getOption('account');
        $priority           = $input->getOption('priority');

        // init the client
        $client = $this->getClient($input);

        $output->writeln("<comment>calling estimateFeeFromAccount($priority, $payment_address_id, $destination, $quantity, $asset)</comment>");
        $result = $client->estimateFeeFromAccount($priority, $payment_address_id, $destination, $quantity, $asset, $account);

        $output->writeln("<info>Fee: ".$result->getSatoshis()." satoshis</info>");
    }

}
