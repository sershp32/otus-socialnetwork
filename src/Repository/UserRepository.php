<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\User;
use Doctrine\DBAL\Connection;

final class UserRepository
{
    private Connection $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function findUserByLogin(string $login): ?User
    {
        $s = $this->conn->prepare('SELECT * FROM users WHERE login = :login');
        $s->execute(['login' => $login]);

        $user = $s->fetch();

        if (!$user) {
            return null;
        }

        return new User($user['login'], $user['password']);
    }
}
