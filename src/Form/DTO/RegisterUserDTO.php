<?php

declare(strict_types=1);

namespace App\Form\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class RegisterUserDTO
{
    /**
     * @Assert\NotBlank
     */
    public ?string $login = null;

    /**
     * @Assert\NotBlank
     */
    public ?string $password = null;

    /**
     * @Assert\NotBlank
     */
    public ?string $firstName = null;

    /**
     * @Assert\NotBlank
     */
    public ?string $lastName = null;

    /**
     * @Assert\NotBlank
     */
    public ?string $city = null;

    /**
     * @Assert\NotBlank
     */
    public ?int $age = null;

    public ?string $interests = null;
}
