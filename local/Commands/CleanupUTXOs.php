<?php

namespace XChainCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tokenly\XChainClient\Client;
use \Exception;

class CleanupUTXOs extends XChainCommand {

    protected $name        = 'x:cleanup';
    protected $description = 'Consolidates address UTXOs';

    protected function configure() {
        parent::configure();

        $this
            ->addArgument(
                'payment-address-id',
                InputArgument::REQUIRED,
                'Payment UUID'
            )
            ->addArgument(
                'count',
                InputArgument::REQUIRED,
                'Number of desired UTXOs'
            )
            ->addOption(
                'fee-priority', 'f',
                InputOption::VALUE_OPTIONAL,
                'Fee',
                'medium'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $payment_address_id = $input->getArgument('payment-address-id');
        $count              = $input->getArgument('count');
        $fee_priority       = $input->getOption('fee-priority');

        // init the client
        $client = $this->getClient($input);

        // get the info
        $payment_address_details = $client->getPaymentAddress($payment_address_id);
        $address = $payment_address_details['address'];
        $output->writeln("<comment>Address is $address</comment>");

        $balances = $client->getBalances($address);
        $btc_balance = $balances['BTC'];
        $output->writeln("<comment>BTC balance is $btc_balance</comment>");

        $output->writeln("<comment>calling cleanupUTXOs($payment_address_id, $count, $fee_priority)</comment>");
        $result = $client->cleanupUTXOs($payment_address_id, $count, $fee_priority);
        $output->writeln("<info>Result\n".json_encode($result, 192)."</info>");
    }

}
