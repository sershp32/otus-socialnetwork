<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\User;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserRepository
{
    private Connection $conn;

    private UserPasswordEncoderInterface $encoder;

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

        return new User((int)$user['id'], (int)$user['profile_id'], $user['login'], $user['password']);
    }

    public function create(array $params): User
    {
        $this->conn->insert('users', $params);

        return new User(
            (int)$this->conn->lastInsertId(),
            (int)$params['profile_id'],
            $params['login'],
            $params['password']
        );
    }

    public function update(int $id, array $params): void
    {
        $this->conn->update('users', $params, ['id' => $id]);
    }
}
