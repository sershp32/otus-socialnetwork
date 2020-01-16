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
            $login = strtolower($name . $faker->numberBetween(10, 10000000));
            $user = new RegisterUserDTO();
            $user->login = $login;
            $user->password = $login;
            $user->firstName = stripslashes(addslashes($name));
            $user->lastName = stripslashes(addslashes($faker->lastName));
            $user->age = $faker->numberBetween(18, 90);
            $user->city = stripslashes(addslashes($faker->city));
            $user->interests = stripslashes(addslashes($faker->sentence(10, true)));
            $this->add($user);
        }

        return 0;
    }

    private function add(RegisterUserDTO $user)
    {
        $profile = sprintf("INSERT INTO profiles (first_name, last_name, age, interests, city) VALUES (\"%s\", \"%s\", %s,\"%s\", \"%s\"); \n",
            $user->firstName, $user->lastName, $user->age, $user->interests, $user->city);
        file_put_contents('docker/mysql/data.sql', $profile, FILE_APPEND);

        $user = sprintf("INSERT INTO users (login, password, profile_id) VALUES (\"%s\", \"%s\", LAST_INSERT_ID()); \n",
            $user->login, md5($user->password));
        file_put_contents('docker/mysql/data.sql', $user, FILE_APPEND);
    }
}
