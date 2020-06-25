<?php

namespace App\Command;

use App\Service\ExtranetService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ExtranetSyncCommand extends Command
{
    protected static $defaultName = 'app:extranetsync';

    public function __construct(ExtranetService $extranetService)
    {
        parent::__construct();
        $this->extranetService = $extranetService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Import from Extranet')
            ->setHelp('This command starts an import from Extranet')
            ->addArgument('username', InputArgument::REQUIRED, 'Extranet username')
            ->addArgument('password', InputArgument::REQUIRED, 'Extranet password')
            ->addArgument('cache', InputArgument::OPTIONAL, 'Use cache instead of fetching data from extranet again');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Starting sync');

        $this->cache = ($input->getArgument('cache') === 'use-cache');
        $this->username = $input->getArgument('username');
        $this->password = $input->getArgument('password');

        $this->extranetService
            ->setCacheFile('var/cache/extranet-data.json')
            ->setCredentials($this->username, $this->password)
            ->useCache($this->cache)
            ->doExtract();

        return 0;
    }
}
