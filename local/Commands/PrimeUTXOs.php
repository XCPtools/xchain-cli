<?php

namespace XChainCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tokenly\XChainClient\Client;
use \Exception;

class PrimeUTXOs extends XChainCommand {

    protected $name        = 'x:prime';
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
            ->addArgument(
                'count',
                InputArgument::REQUIRED,
                'Number of UTXOs to generate'
            )
            ->addOption(
                'fee', 'f',
                InputOption::VALUE_OPTIONAL,
                'Fee',
                0.0001
            )
            ->addOption(
                'account', 'a',
                InputOption::VALUE_OPTIONAL,
                'Account to send from',
                'default'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $payment_address_id = $input->getArgument('payment-address-id');
        $size               = $input->getArgument('size');
        $count              = $input->getArgument('count');
        $fee                = $input->getOption('fee');
        $account            = $input->getOption('account');

        // init the client
        $client = $this->getClient($input);

        // get the info
        $payment_address_details = $client->getPaymentAddress($payment_address_id);
        $address = $payment_address_details['address'];
        $output->writeln("<comment>Address is $address</comment>");

        $balances = $client->getBalances($address);
        $btc_balance = $balances['BTC'];
        $output->writeln("<comment>BTC balance is $btc_balance</comment>");

        try {
            $destinations = $this->buildDestinations($size, $count, $btc_balance, $address, $fee);
        } catch (Exception $e) {
            $output->writeln("<error>".$e->getMessage()."</error>");
            
        }
        $output->writeln("<comment>Destinations are ".json_encode($destinations, 192)."</comment>");


        $output->writeln("<comment>calling sendBTCToMultipleDestinations($payment_address_id, {\$destinations}, $account, FALSE, $fee)</comment>");
        $result = $client->sendBTCToMultipleDestinations($payment_address_id, $destinations, $account, $unconfirmed=false, $fee);
        $output->writeln("<info>Result\n".json_encode($result, 192)."</info>");
    }

    protected function buildDestinations($size, $count, $btc_balance, $address, $fee) {
        $needed_btc = ($size * $count) + $fee;
        if ($needed_btc > $btc_balance) {
            throw new Exception("BTC balance is too low.  Needed $needed_btc and found $btc_balance", 1);
        }

        $destinations = [];
        for ($i=0; $i < $count; $i++) { 
            $destinations[] = ['address' => $address, 'amount' => $size];
        }
        return $destinations;
    }
}
