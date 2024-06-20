<?php

namespace App\Command;

use App\Service\ExtranetService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\HttpKernel\KernelInterface;

class ExtranetSyncCommand extends Command
{
    protected static $defaultName = 'app:extranetsync';
    protected $extranetService;
    protected $projectDir;
    protected $logger;

    public function __construct(ExtranetService $extranetService, KernelInterface $kernel, LoggerInterface $extranetLogger)
    {
        parent::__construct();
        $this->extranetService = $extranetService;
        $this->projectDir = $kernel->getProjectDir();
        $this->logger = $extranetLogger;
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

        $this->logger->info('Starting sync');

        $cache = ($input->getArgument('cache') === 'use-cache');

        chdir($this->projectDir);

        $this->extranetService
            ->setCredentials($username, $password)
            ->useCache($cache)
            ->doExtract();

        return 0;
    }
}
