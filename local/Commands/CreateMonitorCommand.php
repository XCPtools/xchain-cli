<?php

namespace XChainCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tokenly\XChainClient\Client;


class CreateMonitorCommand extends XChainCommand {

    protected $name        = 'x:new-monitor';
    protected $description = 'Creates a new address monitor';

    protected function configure() {
        parent::configure();

        $this
            ->addArgument(
                'address',
                InputArgument::REQUIRED,
                'Bitcoin Address'
            )
            ->addArgument(
                'webook-endpoint',
                InputArgument::REQUIRED,
                'Webhook Endpoint'
            )
            ->addArgument(
                'monitor-type',
                InputArgument::OPTIONAL,
                'Monitor Type (send or receive)',
                'receive'
            )
            ->addArgument(
                'active',
                InputArgument::OPTIONAL,
                'Active Flag',
                true
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $address = $input->getArgument('address');
        $webhook_endpoint = $input->getArgument('webook-endpoint');
        $monitor_type = $input->getArgument('monitor-type');
        $active = $this->formatBoolean($input->getArgument('active'));

        // init the client
        $client = $this->getClient($input);

        $output->writeln("<comment>calling newAddressMonitor($address, $webhook_endpoint, $monitor_type, ".($active?'TRUE':'FALSE').")</comment>");
        $result = $client->newAddressMonitor($address, $webhook_endpoint, $monitor_type, $active);
        $output->writeln("<info>Result\n".json_encode($result, 192)."</info>");
    }

}
