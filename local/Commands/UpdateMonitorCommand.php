<?php

namespace XChainCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tokenly\XChainClient\Client;


class UpdateMonitorCommand extends XChainCommand {

    protected $name        = 'x:update-monitor';
    protected $description = 'Updates an existing address monitor';

    protected function configure() {
        parent::configure();

        $this
            ->addArgument(
                'monitor-id',
                InputArgument::REQUIRED,
                'Monitor UUID'
            )
            ->addArgument(
                'active',
                InputArgument::REQUIRED,
                'New Active Status'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $monitor_id = $input->getArgument('monitor-id');
        $active = $this->formatBoolean($input->getArgument('active'));

        // init the client
        $client = $this->getClient($input);

        $output->writeln("<comment>calling updateAddressMonitorActiveState($monitor_id, ".($active?'TRUE':'FALSE').")</comment>");
        $result = $client->updateAddressMonitorActiveState($monitor_id, $active);
        $output->writeln("<info>Result\n".json_encode($result, 192)."</info>");
    }

}
