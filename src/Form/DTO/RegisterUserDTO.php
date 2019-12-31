<?php

declare(strict_types=1);

namespace App\Form\DTO;

final class RegisterUserDTO
{
    public ?string $login = null;

    public ?string $password = null;

    public ?string $firstName = null;

    public ?string $lastName = null;

    public ?int $age = null;

    public ?string $interests = null;

    public ?string $city = null;
}
