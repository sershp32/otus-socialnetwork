<?php

declare(strict_types=1);

namespace App\Repository;

use App\DBAL\SlaveConnection;
use App\Form\DTO\RegisterUserDTO;
use App\Model\Profile;
use Doctrine\DBAL\Connection;

final class ProfileRepository
{
    private Connection $conn;

    private SlaveConnection $slaveConn;

    public function __construct(Connection $conn, SlaveConnection $slaveConn)
    {
        $this->conn = $conn;
        $this->slaveConn = $slaveConn;
    }

    public function find(int $id): ?Profile
    {
        $s = $this->slaveConn->prepare('SELECT * FROM profiles WHERE id = :id');
        $s->execute(['id' => $id]);

        $profile = $s->fetch();

        if (!$profile) {
            return null;
        }

        return new Profile(
            (int)$profile['id'],
            $profile['first_name'],
            $profile['last_name'],
            (int)$profile['age'],
            $profile['interests'],
            $profile['city']
        );
    }

    public function findAll(): array
    {
        $s = $this->slaveConn->prepare('SELECT * FROM profiles LIMIT 50');
        $s->execute();

        return $s->fetchAll();
    }

    public function findByName(string $firstname, string $lastname): array
    {
        $s = $this->slaveConn->prepare('SELECT * FROM profiles WHERE first_name LIKE :first OR last_name LIKE :last ORDER BY id ASC LIMIT 50');
        $s->execute([
            'first' => $firstname . '%',
            'last' => $lastname . '%',
        ]);

        return $s->fetchAll();
    }

    public function createFromDto(RegisterUserDTO $dto): Profile
    {
        $this->conn->insert('profiles', [
            'first_name' => $dto->firstName,
            'last_name' => $dto->lastName,
            'age' => $dto->age,
            'interests' => $dto->interests,
            'city' => $dto->city,
        ]);

        return new Profile(
            (int)$this->conn->lastInsertId(),
            $dto->firstName,
            $dto->lastName,
            $dto->age,
            $dto->interests,
            $dto->city
        );
    }
}
