<?php

namespace App\Command;

use App\Form\DTO\RegisterUserDTO;
use App\Manager\UserManager;
use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GenerateCommand extends Command
{
    protected static $defaultName = 'generate';

    private UserManager $manager;

    public function __construct(UserManager $manager)
    {
        parent::__construct();

        $this->manager = $manager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate test data')
            ->addArgument('count', InputArgument::REQUIRED, 'Count of users')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $count = $input->getArgument('count');
        $faker = Factory::create();

        for ($i=0; $i<(int)$count; $i++) {
            $name = $faker->firstName;
            $login = strtolower($name . $faker->numberBetween(10, 90));
            $user = new RegisterUserDTO();
            $user->login = $login;
            $user->password = $login;
            $user->firstName = $name;
            $user->lastName = $faker->lastName;
            $user->age = $faker->numberBetween(18, 90);
            $user->city = $faker->city;
            $user->interests = $faker->sentence(10, true);
            $this->manager->createFromDTO($user);
        }

        return 0;
    }
}
