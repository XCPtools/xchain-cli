<?php

namespace XChainCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tokenly\XChainClient\Client;
use \Exception;

class CheckPrimedUTXOs extends XChainCommand {

    protected $name        = 'x:check-primes';
    protected $description = 'Primes an address with UTXOs';

    protected function configure() {
        parent::configure();

        $this
            ->addArgument(
                'payment-address-id',
                InputArgument::REQUIRED,
                'Payment UUID'
            )
            ->addArgument(
                'size',
                InputArgument::REQUIRED,
                'UTXO size'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $payment_address_id = $input->getArgument('payment-address-id');
        $size               = $input->getArgument('size');

        // init the client
        $client = $this->getClient($input);

        // get the info
        $payment_address_details = $client->getPaymentAddress($payment_address_id);
        $address = $payment_address_details['address'];
        $output->writeln("<comment>Address is $address</comment>");

        $balances = $client->getBalances($address);
        $btc_balance = $balances['BTC'];
        $output->writeln("<comment>BTC balance is $btc_balance</comment>");

        $output->writeln("<comment>calling checkPrimedUTXOs($payment_address_id, $size)</comment>");
        $result = $client->checkPrimedUTXOs($payment_address_id, $size);
        $output->writeln("<info>Result\n".json_encode($result, 192)."</info>");
    }

}
