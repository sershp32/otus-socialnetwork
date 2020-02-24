<?php

declare(strict_types=1);

namespace App\Repository;

use App\DBAL\SlaveConnection;
use App\Model\User;
use Doctrine\DBAL\Connection;

final class UserRepository
{
    private Connection $conn;

    private SlaveConnection $slaveConn;

    public function __construct(Connection $conn, SlaveConnection $slaveConn)
    {
        $this->conn = $conn;
        $this->slaveConn = $slaveConn;
    }

    public function findUserByLogin(string $login): ?User
    {
        $s = $this->slaveConn->prepare('SELECT * FROM users WHERE login = :login');
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
