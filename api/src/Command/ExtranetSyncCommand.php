<?php

namespace App\Command;

use App\Service\ExtranetService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\HttpKernel\KernelInterface;

class ExtranetSyncCommand extends Command
{
    protected static $defaultName = 'app:extranetsync';
    protected $projectDir;

    public function __construct(ExtranetService $extranetService, KernelInterface $kernel)
    {
        parent::__construct();
        $this->extranetService = $extranetService;
        $this->projectDir = $kernel->getProjectDir();
    }

    protected function configure()
    {
        $this
            ->setDescription('Import from Extranet')
            ->setHelp('This command starts an import from Extranet')
            ->addArgument('cache', InputArgument::OPTIONAL, 'Use cache instead of fetching data from extranet again');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!isset($_ENV['EXTRANET_USERNAME'])) {
            throw new Exception('Missing env var EXTRANET_USERNAME');
        }

        if (!isset($_ENV['EXTRANET_PASSWORD'])) {
            throw new Exception('Missing env var EXTRANET_PASSWORD');
        }

        $username = $_ENV['EXTRANET_USERNAME'];
        $password = $_ENV['EXTRANET_PASSWORD'];

        $logger = new ConsoleLogger($output);

        $logger->info('Starting sync');

        $this->cache = ($input->getArgument('cache') === 'use-cache');

        chdir($this->projectDir);

        $this->extranetService
            ->setLogger($logger)
            ->setCacheDirectory('./var/cache/')
            ->setCredentials($username, $password)
            ->useCache($this->cache)
            ->doExtract();

        return 0;
    }
}
