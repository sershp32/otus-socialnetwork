<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface
{
    private int $id;

    private int $profileId;

    private string $login;

    private string $password;

    public function __construct(int $id, int $profileId, string $login, string $password)
    {
        $this->id = $id;
        $this->profileId = $profileId;
        $this->login = $login;
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProfileId(): int
    {
        return $this->profileId;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getSalt(): string
    {
        return '123';
    }

    public function getUsername(): string
    {
        return $this->login;
    }

    public function eraseCredentials(): void
    {
        return;
    }
}
