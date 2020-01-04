<?php

declare(strict_types=1);

namespace App\Model;

final class Profile
{
    private int $id;

    private string $firstName;

    private string $lastName;

    private int $age;

    private string $interests;

    private string $city;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        int $age,
        string $interests,
        string $city
    )
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
        $this->interests = $interests;
        $this->city = $city;
    }

    public function getId(): int
    {
        return $this->id;
    }

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
