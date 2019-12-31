<?php

declare(strict_types=1);

namespace App\Model;

final class Profile
{
    private string $firstName;

    private string $lastName;

    private int $age;

    private string $interests;

    private string $city;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getInterests(): string
    {
        return $this->interests;
    }

    public function getCity(): string
    {
        return $this->city;
    }
}
