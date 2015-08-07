<?php

namespace XChainCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tokenly\XChainClient\Client;

class SendCommand extends XChainCommand {

    protected $name        = 'x:send';
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
                'f', 'fee',
                InputOption::VALUE_OPTIONAL,
                'Fee',
                0.0001
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $payment_address_id = $input->getArgument('payment-address-id');
        $destination = $input->getArgument('destination');
        $quantity = $input->getArgument('quantity');
        $asset = $input->getArgument('asset');
        $fee = $input->getOption('f');

        // init the client
        $client = $this->getClient($input);

        $output->writeln("<comment>calling sendConfirmed($payment_address_id, $destination, $quantity, $asset, $fee)</comment>");
        $result = $client->sendConfirmed($payment_address_id, $destination, $quantity, $asset, $fee);
        $output->writeln("<info>Result\n".json_encode($result, 192)."</info>");
    }

}
