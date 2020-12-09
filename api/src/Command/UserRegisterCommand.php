<?php

namespace App\Command;

use App\Service\ExtranetService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;


class UserRegisterCommand extends Command
{
    protected static $defaultName = 'app:user:register';

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->encoder = $encoder;
        $this->em = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a user')
            ->setHelp('This command creates a user you can use for API requests')
            ->addArgument('username', InputArgument::REQUIRED, 'Specify the username')
            ->addArgument('password', InputArgument::REQUIRED, 'Specify the password')
            ->addArgument('apikey', InputArgument::OPTIONAL, 'Specify the apikey');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $apikey = $input->getArgument('apikey');
        $output->writeln('Creating user: ' . $username);

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->encoder->encodePassword($user, $password));
        $user->setAuthToken($apikey);
        $this->em->persist($user);
        $this->em->flush();

        $output->writeln('Created user: ' . $username);

        return 0;
    }
}
