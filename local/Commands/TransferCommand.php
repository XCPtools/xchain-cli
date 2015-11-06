<?php

namespace XChainCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tokenly\XChainClient\Client;

class TransferCommand extends XChainCommand {

    protected $name        = 'x:transfer';
    protected $description = 'transfers founds from one account to another';

    protected function configure() {
        parent::configure();

        $this
            ->addArgument(
                'payment-address-id',
                InputArgument::REQUIRED,
                'Payment UUID'
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
            ->addArgument(
                'from',
                InputArgument::REQUIRED,
                'From account name'
            )
            ->addArgument(
                'to',
                InputArgument::REQUIRED,
                'To account name'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $payment_address_id = $input->getArgument('payment-address-id');
        $from               = $input->getArgument('from');
        $to                 = $input->getArgument('to');
        $quantity           = $input->getArgument('quantity');
        $asset              = $input->getArgument('asset');

        // init the client
        $client = $this->getClient($input);

        $output->writeln("<comment>calling transfer($payment_address_id, $from, $to, $quantity, $asset)</comment>");
        $result = $client->transfer($payment_address_id, $from, $to, $quantity, $asset);
        $output->writeln("<info>Result\n".json_encode($result, 192)."</info>");
    }

}
